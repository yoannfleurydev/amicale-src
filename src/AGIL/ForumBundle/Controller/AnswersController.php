<?php

namespace AGIL\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnswersController extends Controller
{

    /**
     * Partie Contrôleur de la page d'un sujet, qui affiche
     * la liste des réponses par ordre décroissants des dates
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function answersAction($idCategory,$idSubject)
    {
        $manager = $this->getDoctrine()->getManager();

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');
        $category = $categoryRepository->find($idCategory);

        if ($category === null) {
            throw new NotFoundHttpException("La catégorie d'id ".$idCategory." n'existe pas.");
        }

        // Récupération de l'objet Subject par rapport à l'ID spécifié dans l'URL
        $subjectRepository = $manager ->getRepository('AGILForumBundle:AgilForumSubject');
        $subject = $subjectRepository->find($idSubject);

        if ($subject === null) {
            throw new NotFoundHttpException("Le sujet d'id ".$idSubject." n'existe pas.");
        }

        // Récupération des réponses pour le sujet courant
        $answerRepository = $manager ->getRepository('AGILForumBundle:AgilForumAnswer');
        $answers = $answerRepository->findBy(array('subject' => $subject));


        return $this->render('AGILForumBundle:Answers:answers.html.twig',
            array('category' => $category,'subject' => $subject,'answers' => $answers));
    }
}
