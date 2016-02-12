<?php

namespace AGIL\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoriesController extends Controller
{

    /**
     * Partie Contrôleur de la page d'une catégorie, qui affiche
     * la liste des sujets par ordre décroissants des dates de réponses
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subjectsAction($idCategory,$page)
    {
        // Manager & Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');
        $subjectRepository = $manager->getRepository('AGILForumBundle:AgilForumSubject');


        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);
        if ($category === null) {
            $this->addFlash('warning', "La catégorie d'id " . $idCategory . " n'existe pas.");
            return $this->redirectToRoute('agil_forum_homepage');
        }


        // Gestion de la pagination
        $maxSubjects = 15;
        $subject_count = $subjectRepository->getCountSubjects($idCategory);
        // On vérifie que le nombre de pages spécifié dans l'URL n'est pas absurde
        if(($subject_count == 0 && $page != 1) ||
            ($subject_count != 0 && $page > ceil($subject_count / $maxSubjects) || $page <= 0)  ){
            throw new NotFoundHttpException("Erreur dans le numéro de page");
        }
        $pagination = array(
            'page' => $page,
            'route' => 'agil_forum_subjects_list',
            'pages_count' => ceil($subject_count / $maxSubjects),
            'route_params' => array()
        );


        // Récupération des sujets pour la catégorie courante en fonction des dernières réponses
        $subjects = $subjectRepository->getLastSubjectsByAnswer($page,$maxSubjects,$category);


        // Pour chaque sujet, on récupère le nombre de réponses, la date relative du dernier message et les tags
        $countAnswersPerSubject = null;
        $relativeDatePerSubject = null;
        $tagsPerSubject         = null;
        foreach($subjects as $sub){
            $countAnswersPerSubject[$sub['forumSubjectId']] = $subjectRepository->getCountAnswersInSubject($sub['forumSubjectId']);
            $relativeDatePerSubject[$sub['forumSubjectId']] = $this->time_elapsed_string($sub['forumAnswerPostDate']);
            $subject = $subjectRepository->find($sub['forumSubjectId']);
            $tagsPerSubject[$sub['forumSubjectId']] = $subject->getTags();
        }

        return $this->render('AGILForumBundle:Categories:subjects.html.twig',
            array('category' => $category,'subjects' => $subjects,'pagination' => $pagination,
                'countAnswers' => $countAnswersPerSubject, 'relativeDate' => $relativeDatePerSubject,
                'tagsPerSubject' => $tagsPerSubject));
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

}
