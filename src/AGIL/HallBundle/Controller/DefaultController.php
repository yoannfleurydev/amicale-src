<?php

namespace AGIL\HallBundle\Controller;

use Essence\Essence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller {
    const MAX_EVENTS = 10;

	/* index */
	public function indexAction($page) {
		$em = $this->getDoctrine()->getManager();
		$eventRepo = $em->getRepository('AGILHallBundle:AgilEvent');

        $eventCount = $eventRepo->getCountEvents();

        // On vérifie que le nombre de pages spécifié dans l'URL n'est pas absurde
        if(($eventCount == 0 && $page != 1) ||
            ($eventCount != 0 && $page > ceil($eventCount / DefaultController::MAX_EVENTS) || $page <= 0)  ){
            throw new NotFoundHttpException("Erreur dans le numéro de page");
        }

        $pagination = array(
            'page' => $page,
            'route' => 'agil_hall_homepage',
            'pages_count' => ceil($eventCount / DefaultController::MAX_EVENTS),
            'route_params' => array()
        );

        $events = $eventRepo->getEventsByPage($page, DefaultController::MAX_EVENTS);

		return $this->render('AGILHallBundle:Default:index.html.twig', array('events' => $events, 'pagination'=>$pagination));
	}

	/* Affichage d'un événement comme un post de blog */
    public function eventAction($idEvent) {
        $em = $this->getDoctrine()->getManager();
        $eventRepo = $em->getRepository('AGILHallBundle:AgilEvent');
        $event = $eventRepo->find($idEvent);

        $essence = new Essence();

		$text = '<div class="row">' .
            '<div class="col-lg-12">' . $event->getEventText() .
            '</div></div>';

        $eventContent = $essence->replace($text, function($media) {
			return <<<HTML
			<div class="row">
                <div class="well well-lg col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12">
                    <p class="text-primary-blue text-center">
                        $media->title par
                        <a href="$media->authorUrl" title="Accès à la chaine de $media->authorName">
                            $media->authorName
                        </a>
                     </p>
                    <div class="embed-responsive embed-responsive-16by9">$media->html</div>
                </div>
		    </div>
HTML;
		});

        return $this->render('AGILHallBundle:Event:event.html.twig', array('event' => $event, 'eventContent' =>
            $eventContent));
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
