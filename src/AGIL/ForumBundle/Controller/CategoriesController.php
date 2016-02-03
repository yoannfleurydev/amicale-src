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
    public function subjectsAction($idCategory)
    {

        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);

        if ($category === null) {
            throw new NotFoundHttpException("La catégorie d'id ".$idCategory." n'existe pas.");
        }

        $subjectRepository = $manager ->getRepository('AGILForumBundle:AgilForumSubject');

        // Récupération des sujets pour la catégorie courante
        //$subjects = $subjectRepository->findBy(array('category' => $category));
        // REMPLACER LE FINDBY PAR UNE REQUETE DU REPOSITORY EN QUERY BUILDER
        // AFIN DE GERER LA PAGINATION

        $subjects = $subjectRepository->getLastSubjectsByAnswer($category);

        return $this->render('AGILForumBundle:Categories:subjects.html.twig',
            array('category' => $category,'subjects' => $subjects));
    }
}
