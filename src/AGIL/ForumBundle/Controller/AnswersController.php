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
