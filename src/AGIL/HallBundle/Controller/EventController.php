<?php

namespace AGIL\HallBundle\Controller;

use AGIL\HallBundle\Entity\AgilEvent;
use AGIL\HallBundle\Entity\AgilPhoto;
use AGIL\HallBundle\Form\EditEventType;
use AGIL\HallBundle\Form\AddEventType;
use AGIL\HallBundle\Form\PhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\VarDumper\VarDumper;

class EventController extends Controller
{
    /**
     * Ajout d'événement
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function eventAddAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $photo = new AgilPhoto();
        $form = $this->createForm(new PhotoType(), $photo);

        $form->handleRequest($request);
        if($form->isValid()) {
            $event = $form->get('event')->getData();
            $event->setUser($this->getUser());

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Evénement ajouté');
            return $this->redirect($this->generateUrl('agil_hall_event', array('idEvent' => $event->getEventId())));
        }

        return $this->render('AGILHallBundle:Event:event_add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Edition d'événement
     * @param $idEvent
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function eventEditAction ($idEvent, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('AGILHallBundle:AgilEvent')->find($idEvent);

        if (null === $event) {
            throw new NotFoundHttpException("L'evénement d'id " . $idEvent . " n'existe pas.");
        }

        $form = $this->createForm(new EditEventType(), $event);

        // Remplissage des champs qui ont une valeur
        $form->get('eventTitle')->setData($event->getEventTitle());
        $form->get('eventText')->setData($event->getEventText());
        $form->get('eventDate')->setData($event->getEventDate());
        $form->get('eventDateEnd')->setData($event->getEventDate());
        $form->handleRequest($request);

        if($form->isValid()) {
            $em->flush();

            $this->addFlash('success', "L'évenement a été modifié");

            return $this->redirect($this->generateUrl('agil_hall_event', array('idEvent' => $event->getEventId())));
        }

        return $this->render('AGILHallBundle:Event:event_edit.html.twig', array(
            'event' => $event,
            'form'  => $form->createView()
        ));

        return $this->render('AGILHallBundle:Event:event_edit.html.twig');
    }

    public function eventDeleteAction ($idEvent) {

        return $this->redirect($this->generateUrl('agil_hall_homepage'));
    }
}
