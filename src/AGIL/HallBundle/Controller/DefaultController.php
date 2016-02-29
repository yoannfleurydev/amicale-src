<?php

namespace AGIL\HallBundle\Controller;

use AGIL\HallBundle\Entity\AgilEvent;
use AGIL\HallBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;


class DefaultController extends Controller
{
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

    public function eventAddAction(Request $request) {
        $event = new AgilEvent();

        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $event->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Evenement ajouté');
//            return $this->redirect($this->generateUrl('agil_hall_event', array('id' => $event->getEventId())));
        }

        return $this->render('AGILHallBundle:Default:eventAdd.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function eventEditAction($idEvent, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('AGILHallBundle:AgilEvent')->find($idEvent);

        $form = $this->createForm(new EventType(), $event);

        // Remplissage des champs qui ont une valeur
        $form->get('eventTitle')->setData($event->getEventTitle());
        $form->get('eventText')->setData($event->getEventText());
        $form->get('eventDate')->setData($event->getEventDate());

        $form->handleRequest($request);

        if($form->isValid()) {
            $em->flush();
        }

        return $this->render('AGILHallBundle:Default:eventEdit.html.twig', array(
            'event' => $event,
            'form'  => $form->createView()
        ));
    }
}