<?php

namespace AGIL\HallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller {
    private static $MAX_EVENTS = 10;

	/* index */
	public function indexAction($page) {
		$em = $this->getDoctrine()->getManager();
		$eventRepo = $em->getRepository('AGILHallBundle:AgilEvent');
		$events = $eventRepo->findAll();

        $eventCount = $eventRepo->getCountEvents();
        // On vérifie que le nombre de pages spécifié dans l'URL n'est pas absurde
        if(($eventCount == 0 && $page != 1) ||
            ($eventCount != 0 && $page > ceil($eventCount / DefaultController::$MAX_EVENTS) || $page <= 0)  ){
            throw new NotFoundHttpException("Erreur dans le numéro de page");
        }

        $pagination = array(
            'page' => $page,
            'route' => 'agil_hall_homepage',
            'pages_count' => ceil($eventCount / DefaultController::$MAX_EVENTS),
            'route_params' => array()
        );

		return $this->render('AGILHallBundle:Default:index.html.twig', array('events' => $events, 'pagination'=>$pagination));
	}

	/* Affichage de la page souhaitée *//*
    public function renderPageAction($idPage) {
	    // TODO Faire la pagination
	    return $this->render('AGILHallBundle:Default:index.html.twig');
    }*/

	/* Affichage d'un événement */
	public function eventAction($idEvent) {
		$em = $this->getDoctrine()->getManager();
		$eventRepo = $em->getRepository('AGILHallBundle:AgilEvent');
		$event = $eventRepo->find($idEvent);

		return $this->render('AGILHallBundle:Event:event.html.twig', array('event' => $event));
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
