<?php

namespace AGIL\AdminBundle\Controller;

use AGIL\HallBundle\Entity\AgilEvent;
use AGIL\HallBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    public function adminEventAction() {

    }

    public function adminEventAddAction(Request $request) {
        $event = new AgilEvent();

        $form = $this->createForm(new EventType(), $event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $event->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Evenement ajouté');

            return $this->redirect($this->generateUrl('agil_admin_events', array('id' => $event->getEventId())));
        }
        return $this->render('AGILAdminBundle:Event:admin_event_add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function adminEventEditAction ($idEvent, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('AGILHallBundle:AgilEvent')->find($idEvent);

        if (null === $event) {
            throw new NotFoundHttpException("L'evénement d'id " . $id . " n'existe pas.");
        }

        $form = $this->createForm(new EventType(), $event);

        // Remplissage des champs qui ont une valeur
        $form->get('eventTitle')->setData($event->getEventTitle());
        $form->get('eventText')->setData($event->getEventText());
        $form->get('eventDate')->setData($event->getEventDate());

        $form->handleRequest($request);

        if($form->isValid()) {
            $em->flush();

            $this->addFlash('success', "L'évenement a été modifié");

            return $this->redirect($this->generateUrl('agil_admin_events', array('id' => $event->getEventId())));
        }

        return $this->render('AGILAdminBundle:Event:admin_event_edit.html.twig', array(
            'event' => $event,
            'form'  => $form->createView()
        ));

        return $this->render('AGILAdminBundle:Event:admin_event_edit.html.twig');
    }

    public function adminEventDeleteAction ($idEvent) {

        return $this->redirect($this->generateUrl('AGILHallBundle:Event:admin_event.html.twig'));
    }
}
