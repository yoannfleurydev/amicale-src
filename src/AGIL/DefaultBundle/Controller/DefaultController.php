<?php

namespace AGIL\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * Méthode qui construit la page d'accueil
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();

        // Repository des Sujets de forum
        $subjectRepository = $manager->getRepository('AGILForumBundle:AgilForumSubject');

        // Récupération des 3 derniers sujets de forum créés
        $lastSubjects = $subjectRepository->findBy(array(),array('forumSubjectPostDate' => 'desc'),3);

        return $this->render('AGILDefaultBundle:Default:index.html.twig',
            array('lastSubjects' => $lastSubjects));
    }
}
