<?php

namespace AGIL\ForumBundle\Controller;

use AGIL\ForumBundle\Entity\AgilForumAnswer;
use AGIL\ForumBundle\Form\DeleteAnswerAdminType;
use AGIL\ForumBundle\Form\DeleteAnswerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AGIL\ForumBundle\Form\EditAnswerType;
use AGIL\ForumBundle\Form\AddAnswerType;

class AnswersController extends Controller
{



    /**
     * Partie Contrôleur de la page d'un sujet, qui affiche
     * la liste des réponses par ordre décroissants des dates
     * et qui permet d'ajouter une réponse en dessous
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function answersAction($idCategory,$idSubject,$page, Request $request)
    {
        // Manager & Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager->getRepository('AGILForumBundle:AgilForumCategory');
        $subjectRepository = $manager->getRepository('AGILForumBundle:AgilForumSubject');
        $user = $this->getUser();

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);
        if ($category === null) {
            $this->addFlash('warning', "La catégorie d'id " . $idCategory . " n'existe pas.");
            return $this->redirectToRoute('agil_forum_homepage');
        }

        // Récupération de l'objet Subject par rapport à l'ID spécifié dans l'URL
        $subject = $subjectRepository->find($idSubject);
        if ($subject === null) {
            $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'existe pas.");
            return $this->redirectToRoute('agil_forum_subjects_list', array('idCategory' => $idCategory));
        }

        // On vérifie que le Subject appartient bien à cette Category
        if ($subject->getCategory() != $category) {
            $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'appartient pas à la catégorie d'id ".$idCategory);
            return $this->redirectToRoute('agil_forum_subjects_list', array('idCategory' => $idCategory));
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


        // Formulaire d'ajout de réponse
        $answer = new AgilForumAnswer($subject,$user,null);

        $form = $this->createForm(new AddAnswerType(), $answer);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->persist($answer);
            $manager->flush($answer);

            return $this->redirect( $this->generateUrl('agil_forum_subject_answers',
                array('idCategory' => $idCategory, 'idSubject' => $idSubject, 'page' => ceil($answers_count / $maxAnswers))) );
        }

        return $this->render('AGILForumBundle:Answers:answers.html.twig',
            array('category' => $category,'subject' => $subject,'pagination' => $pagination,
                'answers' => $answers, 'relativeDate' => $relativeDatePerAnswer,
                'form' => $form->createView(),'userTagsSkills' => $userTagsSkills));
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

    /**
     * Cette méthode permet d'éditer une réponse dans le forum
     *
     * @param $idCategory
     * @param $idSubject
     * @param $idAnswer
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function answersEditAction($idCategory, $idSubject, $idAnswer, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $categoryRepository = $em->getRepository('AGILForumBundle:AgilForumCategory');
        $subjectRepository = $em->getRepository("AGILForumBundle:AgilForumSubject");
        $answerRepository = $em->getRepository("AGILForumBundle:AgilForumAnswer");

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);
        if ($category === null) {
            $this->addFlash('warning', "La catégorie d'id " . $idCategory . " n'existe pas.");
            return $this->redirectToRoute('agil_forum_homepage');
        }

        // Récupération de l'objet Subject par rapport à l'ID spécifié dans l'URL
        $subject = $subjectRepository->find($idSubject);
        if ($subject === null) {
            $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'existe pas.");
            return $this->redirectToRoute('agil_forum_subjects_list', array('idCategory' => $idCategory));
        }

        // On vérifie que le Subject appartient bien à cette Category
        if ($subject->getCategory() != $category) {
            $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'appartient pas à la catégorie d'id ".$idCategory);
            return $this->redirectToRoute('agil_forum_subjects_list', array('idCategory' => $idCategory));
        }

        // Récupération de l'objet Answer par rapport à l'ID spécifié dans l'URL
        $answer = $answerRepository->find($idAnswer);
        if ($answer === null) {
            $this->addFlash('warning', "La réponse d'id ".$idAnswer." n'existe pas.");
            return $this->redirectToRoute('agil_forum_subject_answers', array('idCategory' => $idCategory, 'idSubject' => $idSubject));
        }

        // On vérifie que la réponse appartient bien au sujet
        if ($answer->getSubject() != $subject) {
            $this->addFlash('warning', "La réponse d'id ".$idAnswer." n'appartient pas au sujet d'id ".$idSubject);
            return $this->redirectToRoute('agil_forum_subject_answers', array('idCategory' => $idCategory, 'idSubject' => $idSubject));
        }

        // On vérifie que la réponse est bien celle du user connecté
        if ($answer->getUser() != $user) {
            $this->addFlash('notice', 'Permission refusée : vous n\'êtes pas l\'auteur du sujet');

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list',
                array('idCategory' => $idCategory)) );
        }

        // On vérifie que la réponse appartient bien au sujet
        if ($answer->getSubject() != $subject) {
            $this->addFlash('notice', 'Permission refusée : ce message n\'existe pas dans ce sujet');

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list',
                array('idCategory' => $idCategory)) );
        }


        $form = $this->createForm(new EditAnswerType(), $answer);


        // On récupère les réponses pour rédiriger l'utilisateur sur la bonne page
        $answers = $answerRepository->findBy(array('subject' => $subject),array('forumAnswerPostDate' => 'asc'));
        $maxAnswers = 10;
        $index = array_search($answer, $answers);


        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($answer);
            $em->flush($answer);

            return $this->redirect( $this->generateUrl('agil_forum_subject_answers',
                array('idCategory' => $idCategory, 'idSubject' => $idSubject, 'page' => ceil(($index+1) / $maxAnswers))) );
        }

        return $this->render('AGILForumBundle:Answers:answers_edit.html.twig', array(
            'form' => $form->createView(),
            'subject' => $subject,
            'idCategory' => $idCategory,
            'idSubject' => $idSubject,
            'idAnswer' => $idAnswer
        ));
    }


    /**
     * Cette fonction permet de supprimer une réponse d'un sujet
     *
     * @param $idCategory
     * @param $idSubject
     * @param $idAnswer
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function answersDeleteAction($idCategory, $idSubject, $idAnswer, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $subject = $em->getRepository("AGILForumBundle:AgilForumSubject")->find($idSubject);
        $category = $em->getRepository("AGILForumBundle:AgilForumCategory")->find($idCategory);
        $answer = $em->getRepository("AGILForumBundle:AgilForumAnswer")->find($idAnswer);
        if ($category === null or $subject === null  or $answer === null or $subject->getCategory() != $category
            or $answer->getSubject() != $subject) {
            if ($category === null) {
                $this->addFlash('warning', "La catégorie d'id " . $idCategory . " n'existe pas.");
            } elseif ($subject === null) {
                $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'existe pas.");
            } elseif ($answer === null) {
                $this->addFlash('warning', "La réponse d'id ".$idAnswer." n'existe pas.");
            } else if ($subject->getCategory() != $category) {
                $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'appartient pas à la catégorie d'id ".$idCategory);
            } else if ($answer->getSubject() != $subject) {
                $this->addFlash('warning', "La réponse d'id ".$idAnswer." n'appartient pas au sujet d'id ".$idSubject);
            }

            return $this->redirect( $this->generateUrl('agil_forum_subject_answers', array(
                'idCategory' => $idCategory,
                'idSubject' => $idSubject
            )));
        }

        $author = $answer->getUser();
        $text = $answer->getForumAnswerText();

        if (!$user->hasRole('ROLE_MODERATOR') and !$user->hasRole('ROLE_ADMIN') and !$user->hasRole('ROLE_SUPER_ADMIN')) {
            $this->addFlash('warning', 'Permission refusée : vous n\'êtes pas l\'autheur du sujet');

            return $this->redirect( $this->generateUrl('agil_forum_subject_answers', array(
                'idCategory' => $idCategory,
                'idSubject' => $idSubject
            )));
        }

        $isAdmin = false;
        if ($user->hasRole('ROLE_MODERATOR') or $user->hasRole('ROLE_ADMIN') or $user->hasRole('ROLE_SUPER_ADMIN')) {
            $form = $this->createForm(new DeleteAnswerAdminType(), null);
            $isAdmin = true;
        } else {
            $form = $this->createForm(new DeleteAnswerType(), null);
        }

        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($isAdmin) {
                $reason = $form->get('reason')->getData();
                $subjectMail = "Amicale GIL[Suppression d'une réponse d'un sujet du forum]";
                $message = '<p>Bonjour ' . $author->getUsername() . ',</p>';
                $message .= '<p>votre réponse "' . $text . '" au sujet ' .
                    $subject->getForumSubjectTitle() . '" a été supprimé du forum.</p>';
                $message .= "<p>Raison de la suppression :</p>";
                $message .= '<p>"' . $reason . '"</p>';
                $message .= "<p>Cordialement</p>";

                $this->sendMail($subjectMail, $message, $author->getEmail());
            }

            $em->remove($answer);
            $em->flush();

            return $this->redirect( $this->generateUrl('agil_forum_subject_answers', array(
                'idCategory' => $idCategory,
                'idSubject' => $idSubject
            )));
        }

        return $this->render('AGILForumBundle:Answers:answer_delete.html.twig', array(
            'form' => $form->createView(),
            'answer' => $answer,
            'idCategory' => $idCategory,
            'idSubject' => $idSubject,
            'idAnswer' => $idAnswer,
            'isAdmin' => $isAdmin
        ));
    }

    /**
     * fonction d'envoie de mail
     * @param $subject
     * @param $body
     * @param $to
     */
    function sendMail($subject, $body, $to) {
        $headers = 'From: amicale.gil@etu.univ-rouen.fr' . "\r\n";
        $headers .= "Reply-To: amicale.gil@etu.univ-rouen.fr\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"";

        $message = "
    <html>
        <head></head>
        <body>
            $body
        </body>
    </html>";

        if(mail($to, $subject, $message, $headers))
        {
            $this->addFlash('success', 'Mail envoyé !');
        }
        else
        {
            $this->addFlash('warning', 'Erreur lors de l\'envois de l\'email.');
        }

    }
}
