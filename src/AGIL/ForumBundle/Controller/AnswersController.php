<?php

namespace AGIL\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AGIL\ForumBundle\Form\SubjectType;
use AGIL\ForumBundle\Form\FirstAnswerType;
use AGIL\ForumBundle\Form\AnswerType;

class AnswersController extends Controller
{

    /**
     * Partie Contrôleur de la page d'un sujet, qui affiche
     * la liste des réponses par ordre décroissants des dates
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function answersAction($idCategory,$idSubject,$page)
    {
        // Manager & Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager->getRepository('AGILForumBundle:AgilForumCategory');
        $subjectRepository = $manager->getRepository('AGILForumBundle:AgilForumSubject');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);
        if ($category === null) {
            throw new NotFoundHttpException("La catégorie d'id ".$idCategory." n'existe pas.");
        }

        // Récupération de l'objet Subject par rapport à l'ID spécifié dans l'URL
        $subject = $subjectRepository->find($idSubject);
        if ($subject === null) {
            throw new NotFoundHttpException("Le sujet d'id ".$idSubject." n'existe pas.");
        }

        // On vérifie que le Subject appartient bien à cette Category
        if ($subject->getCategory() != $category) {
            throw new NotFoundHttpException("Le sujet d'id ".$idSubject." n'appartient pas à la catégorie d'id ".$idCategory);
        }


        // Gestion de la pagination
        $maxAnswers = 10;
        $answers_count = $manager->getRepository('AGILForumBundle:AgilForumSubject')->getCountAnswersInSubject($idSubject);

        // On vérifie que le nombre de pages spécifié dans l'URL n'est pas absurde
        if($page > ceil($answers_count / $maxAnswers) || $page <= 0 ){
            throw new NotFoundHttpException("Erreur dans le numéro de page");
        }

        $pagination = array(
            'page' => $page,
            'route' => 'agil_forum_subject_answers',
            'pages_count' => ceil($answers_count / $maxAnswers),
            'route_params' => array()
        );


        // Récupération des réponses pour le sujet courant
        $answerRepository = $manager ->getRepository('AGILForumBundle:AgilForumAnswer');
        $answers = $answerRepository->getAnswersBySubject($page,$maxAnswers,$subject);


        // Pour chaque réponse, on récupère la date relative et l'ID du User
        $relativeDatePerAnswer = null;
        $userIdsList = array(); // Liste d'IDs de Users
        foreach($answers as $ans){
            $relativeDatePerAnswer[$ans['forumAnswerId']] = $this->time_elapsed_string($ans['forumAnswerPostDate']);
            // Si un ID de user n'est pas dans la liste, on l'ajoute
            if(!in_array($ans['id'], $userIdsList, true)){
                array_push($userIdsList,$ans['id']);
            }
        }

        // Pour chaque user dans la userIdsList, on récupère ses 5 meilleurs tags
        $userRepository = $manager->getRepository('AGILProfileBundle:AgilSkill');
        $userTagsSkills = null;
        foreach($userIdsList as $id){
            $userTagsSkills[$id] = $userRepository->findBy(array('user' => $id),array('skillLevel' => 'desc'),5);
        }

        return $this->render('AGILForumBundle:Answers:answers.html.twig',
            array('category' => $category,'subject' => $subject,'pagination' => $pagination,
                'answers' => $answers, 'relativeDate' => $relativeDatePerAnswer, 'userTagsSkills' => $userTagsSkills));
    }

    /**
     * Permet d'avoir la date relative
     *
     * @param $datetime
     * @return string
     */
    function time_elapsed_string($datetime) {

        $etime = time() - $datetime->getTimestamp();

        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array( 12 * 30 * 24 * 60 * 60  =>  'année',
            30 * 24 * 60 * 60       =>  'mois',
            24 * 60 * 60            =>  'jour',
            60 * 60                 =>  'heure',
            60                      =>  'minute',
            1                       =>  'seconde'
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                $s = $r . ' ' . $str;
                if($str != 'mois')
                    return $s . ($r > 1 ? 's' : '');
                else
                    return $s;
            }
        }
    }

    public function answersEditAction($idCategory, $idSubject, $idAnswer, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $subject = $em->getRepository("AGILForumBundle:AgilForumSubject")->find($idSubject);
        $answer = $em->getRepository("AGILForumBundle:AgilForumAnswer")->find($idAnswer);

        if ($answer->getUser() != $user) {
            $this->addFlash('notice', 'Permission refusée : vous n\'êtes pas l\'autheur du sujet');

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list',
                array('idCategory' => $idCategory)) );
        }
        if ($answer->getSubject() != $subject) {
            $this->addFlash('notice', 'Permission refusée : ce message n\'existe pas dans ce sujet');

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list',
                array('idCategory' => $idCategory)) );
        }

        $form = $this->createForm(new AnswerType(), $answer);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($answer);
            $em->flush($answer);

            return $this->redirect( $this->generateUrl('agil_forum_subject_answers',
                array('idCategory' => $idCategory, 'idSubject' => $idSubject)) );
        }

        return $this->render('AGILForumBundle:Answers:answers_edit.html.twig', array(
            'form' => $form->createView(),
            'subject' => $subject,
            'idCategory' => $idCategory,
            'idSubject' => $idSubject,
            'idAnswer' => $idAnswer
        ));
    }
}
