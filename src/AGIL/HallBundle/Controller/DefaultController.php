<?php

namespace AGIL\HallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
    /* index */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $eventRepo = $em->getRepository('AGILHallBundle:AgilEvent');
        $events = $eventRepo->findAll();

        return $this->render('AGILHallBundle:Default:index.html.twig', array('listEvents' => $events));
    }

    /* Affichage de la page souhaitée */
    public function renderPageAction($idPage) {
        // TODO Faire la pagination
        return $this->render('AGILHallBundle:Default:index.html.twig');
    }

    /* Affichage d'un événement */
    public function eventAction($idEvent) {
        $em = $this->getDoctrine()->getManager();
        $eventRepo = $em->getRepository('AGILHallBundle:AgilEvent');
        $event = $eventRepo->find($idEvent);

        return $this->render('AGILHallBundle:Default:event.html.twig', array('event' => $event));
    }

    /* Affichage des photos d'un événement */
    public function photosEventAction($idEvent) {
        $em = $this->getDoctrine()->getManager();
        $photoRepo = $em->getRepository('AGILHallBundle:AgilPhoto');
        $photos = $photoRepo->findByEvent($idEvent);

        return $this->render('AGILHallBundle:Default:photoEvent.html.twig', array('photos' => $photos));
    }

    /* Affichage des vidéos d'un événement */
    public function videosEventAction($idEvent) {
        $em = $this->getDoctrine()->getManager();
        $videoRepo = $em->getRepository('AGILHallBundle:AgilPhoto');
        $videos = $videoRepo->findByEvent($idEvent);

        return $this->render('AGILHallBundle:Default:videoEvent.html.twig');
    }
}