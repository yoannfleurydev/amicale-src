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

        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);

        if ($category === null) {
            throw new NotFoundHttpException("La catégorie d'id ".$idCategory." n'existe pas.");
        }

        $subjectRepository = $manager->getRepository('AGILForumBundle:AgilForumSubject');

        // Récupération des sujets pour la catégorie courante en fonction des dernières réponses

        $maxSubjects = 2;
        $subject_count = $manager->getRepository('AGILForumBundle:AgilForumSubject')->getCountSubjects($idCategory);

        $pagination = array(
            'page' => $page,
            'route' => 'agil_forum_subjects_list',
            'pages_count' => ceil($subject_count / $maxSubjects),
            'route_params' => array()
        );

        $subjects = $subjectRepository->getLastSubjectsByAnswer($page,$maxSubjects,$category);

        return $this->render('AGILForumBundle:Categories:subjects.html.twig',
            array('category' => $category,'subjects' => $subjects,'pagination' => $pagination));
    }
}
