<?php

namespace AGIL\HallBundle\Controller;

use AGIL\HallBundle\Entity\AgilEvent;
use AGIL\HallBundle\Entity\AgilPhoto;
use AGIL\HallBundle\Form\EditEventType;
use AGIL\HallBundle\Form\AddEventType;
use AGIL\HallBundle\Form\PhotoType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\Image;
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
        $event = new AgilEvent();
        $form = $this->createForm(new AddEventType(), null);

        $form->handleRequest($request);
        if($form->isValid()) {
            $event->setUser($this->getUser());
            $event->setEventTitle($form->get('eventTitle')->getData());
            $event->setEventText($form->get('eventText')->getData());
            $event->setEventDateEnd($form->get('eventDateEnd')->getData());
            $event->setEventDate($form->get('eventDate')->getData());

            if ($form->get('photos')->getData() != null) {
                $array = new ArrayCollection();
                foreach ($form->get('photos')->getData() as $item) {
                    if ($item != null && $item != "") {
                        if ($item->guessExtension() != "jpeg" && $item->guessExtension() != "png"
                            && $item->guessExtension() != "gif") {
                            $this->addFlash('warning', 'Erreur ! Le format de l\'image ne convient pas ! (formats autorisés: jpeg,png,gif)');
                            return $this->redirect($this->generateUrl('agil_hall_event_add'));
                        } // On vérifie la taille du fichier
                        else if($item->getClientSize() > 1024000) {
                            $this->addFlash('warning', 'Erreur ! La taille de l\'image dépasse la limite ! (limite autorisée: 1Mo)');
                            return $this->redirect($this->generateUrl('agil_hall_event_add'));
                        }

                        $fileName = md5(uniqid()) . '.' . $item->guessExtension();
                        $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/hall';
                        $item->move($dir, $fileName);

                        $photo = new AgilPhoto();
                        $photo->setPhotoUrl($fileName);
                        $photo->setPhotoDescription("");
                        $photo->setPhotoTitle($item->getClientOriginalName());

                        $array->add($photo);
                        $em->persist($photo);
                    }
                }
                $event->setImages($array);
            }

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
