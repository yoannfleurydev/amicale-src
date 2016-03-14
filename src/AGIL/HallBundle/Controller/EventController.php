<?php

namespace AGIL\HallBundle\Controller;

use AGIL\DefaultBundle\Entity\AgilTag;
use AGIL\HallBundle\Entity\AgilEvent;
use AGIL\HallBundle\Entity\AgilPhoto;
use AGIL\HallBundle\Form\DeleteEventType;
use AGIL\HallBundle\Form\EditEventType;
use AGIL\HallBundle\Form\AddEventType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Essence\Essence;
use Symfony\Component\VarDumper\VarDumper;

class EventController extends Controller
{
    /**
     * Ajout d'événement
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function eventAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event = new AgilEvent();
        $form = $this->createForm(new AddEventType(), null);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $event->setUser($this->getUser());

            if (empty($em->getRepository('AGILHallBundle:AgilEvent')->findBy(
                array('eventTitle'=> $form->get('eventTitle')->getData())))) {
                $event->setEventTitle($form->get('eventTitle')->getData());
            } else {
                $this->addFlash('warning', 'Titre de l\'événement déjà utilisé.');
                return $this->redirect($this->generateUrl('agil_hall_event_add'));
            }
            $event->setEventText($form->get('eventText')->getData());
            $event->setEventDateEnd($form->get('eventDateEnd')->getData());
            $event->setEventDate($form->get('eventDate')->getData());

            // les tags
            $tagsArrayString = explode(" ", $form->get('tags')->getData());
            $tagsManager = $this->get('agil_default.tags');
            foreach ($tagsArrayString as $tag) {
                $tagsManager->insertTag($tag);
            }
            $tagsManager->insertDone();
            $event->setTags($em->getRepository("AGILDefaultBundle:AgilTag")->findByTagName($tagsArrayString));

            // Uploads photos
            if ($form->get('photos')->getData()[0] != null) {

                $nbInputs = 0;
                $inputPhoto = $form->get('photos')->getData()[$nbInputs];
                while(!empty($inputPhoto)) {
                    $array = new ArrayCollection();
                    foreach ($inputPhoto as $item) {
                        if ($item != null && $item != "") {
                            if ($item->guessExtension() != "jpeg" && $item->guessExtension() != "png"
                                && $item->guessExtension() != "gif"
                            ) {
                                $this->addFlash('warning', 'Erreur ! Le format de l\'image ne convient pas ! (formats autorisés: jpeg,png,gif)');
                                return $this->redirect($this->generateUrl('agil_hall_event_add'));
                            } // On vérifie la taille du fichier
                            else if ($item->getClientSize() > 1024000) {
                                $this->addFlash('warning', 'Erreur ! La taille de l\'image dépasse la limite ! (limite autorisée: 1Mo)');
                                return $this->redirect($this->generateUrl('agil_hall_event_add'));
                            }

                            $fileName = md5(uniqid()) . '.' . $item->guessExtension();
                            $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/hall';
                            $item->move($dir, $fileName);

                            $photo = new AgilPhoto();
                            $photo->setPhotoUrl($fileName);
                            $photo->setPhotoTitle($item->getClientOriginalName());

                            $array->add($photo);
                            $photo->setEvent($event);
                            $em->persist($photo);
                        }
                    }
                    $nbInputs++;
                    if(!empty($form->get('photos')->getData()[$nbInputs])) {
                        $inputPhoto = $form->get('photos')->getData()[$nbInputs];
                    } else {
                        $inputPhoto = null;
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
    public function eventEditAction($idEvent, Request $request)
    {
        $user = $this->getUser();
        if (!$user->hasRole('ROLE_ADMIN') and !$user->hasRole('ROLE_SUPER_ADMIN')) {
            $this->addFlash('warning', 'Permission refusée');
            return $this->redirect($this->generateUrl('agil_hall_homepage'));
        }
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('AGILHallBundle:AgilEvent')->find($idEvent);

        $files = new ArrayCollection();
        /*$fs = new Filesystem();
        foreach($event->getPhotos() as $photo) {
            $files->add(new UploadedFile($photo->getPhotoUrl(), $photo->getPhotoTitle(), null, 1000000, null, false));
        }*/
        $form = $this->createForm(new EditEventType($files), null);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($event->getEventTitle() != $form->get('eventTitle')->getData()) {
                $eventTmp = $em->getRepository('AGILHallBundle:AgilEvent')->findBy(
                    array('eventTitle'=> $form->get('eventTitle')->getData())
                );
                if (!empty($eventTmp)) {
                    $this->addFlash('warning', 'Titre de l\'événement déjà utilisé.');
                    return $this->redirect($this->generateUrl('agil_hall_event_edit'));
                }
            }

            $event->setEventTitle($form->get('eventTitle')->getData());
            $event->setEventText($form->get('eventText')->getData());
            $event->setEventDateEnd($form->get('eventDateEnd')->getData());
            $event->setEventDate($form->get('eventDate')->getData());

            // les tags
            $tagsArrayString = explode(" ", $form->get('tags')->getData());
            $tagsManager = $this->get('agil_default.tags');
            foreach ($tagsArrayString as $tag) {
                    $tagsManager->insertTag($tag);
            }
            $tagsManager->insertDone();
            $event->removeTags();
            $em->persist($event);
            $em->flush();
            $event->setTags($em->getRepository("AGILDefaultBundle:AgilTag")->findByTagName($tagsArrayString));

            if ($form->get('photos')->getData()[0] != null) {

                $nbInputs = 0;
                $inputPhoto = $form->get('photos')->getData()[$nbInputs];
                while(!empty($inputPhoto)) {
                    $array = new ArrayCollection();
                    foreach ($inputPhoto as $item) {
                        if ($item != null && $item != "") {
                            if ($item->guessExtension() != "jpeg" && $item->guessExtension() != "png"
                                && $item->guessExtension() != "gif"
                            ) {
                                $this->addFlash('warning', 'Erreur ! Le format de l\'image ne convient pas ! (formats autorisés: jpeg,png,gif)');
                                return $this->redirect($this->generateUrl('agil_hall_event_edit'));
                            } // On vérifie la taille du fichier
                            else if ($item->getClientSize() > 1024000) {
                                $this->addFlash('warning', 'Erreur ! La taille de l\'image dépasse la limite ! (limite autorisée: 1Mo)');
                                return $this->redirect($this->generateUrl('agil_hall_event_edit'));
                            }

                            $fileName = md5(uniqid()) . '.' . $item->guessExtension();
                            $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/hall';
                            $item->move($dir, $fileName);

                            $photo = new AgilPhoto();
                            $photo->setPhotoUrl($fileName);
                            $photo->setPhotoTitle($item->getClientOriginalName());

                            $array->add($photo);
                            $photo->setEvent($event);
                            $em->persist($photo);
                        }
                    }
                    $nbInputs++;
                    if(!empty($form->get('photos')->getData()[$nbInputs])) {
                        $inputPhoto = $form->get('photos')->getData()[$nbInputs];
                    } else {
                        $inputPhoto = null;
                    }
                }
                $event->setImages($array);
            }

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Evénement modifié');
            return $this->redirect($this->generateUrl('agil_hall_event', array('idEvent' => $event->getEventId())));
        }

        $form->get('eventTitle')->setData($event->getEventTitle());
        $form->get('eventText')->setData($event->getEventText());
        $form->get('eventDate')->setData($event->getEventDate());
        $form->get('eventDateEnd')->setData($event->getEventDateEnd());
        //$form->get('photos')->setData($event->getPhotos());
        $tagArray = "";
        $count_tags = count($event->getTags());
        $count = 0;
        foreach($event->getTags() as $tag) {
            $count++;
            $tagArray .= $tag->getTagName() . " ";
        }
        $form->get('tags')->setData($tagArray);

        return $this->render('AGILHallBundle:Event:event_edit.html.twig', array(
            'form' => $form->createView(),
            'event' => $event
        ));
    }

    public function eventDeleteAction($idEvent, Request $request)
    {
        $user = $this->getUser();
        if (!$user->hasRole('ROLE_ADMIN') and !$user->hasRole('ROLE_SUPER_ADMIN')) {
            $this->addFlash('warning', 'Permission refusée');
            return $this->redirect($this->generateUrl('agil_hall_homepage'));
        }

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $event = $em->getRepository('AGILHallBundle:AgilEvent')->find($idEvent);

        if (null === $event) {
            throw new NotFoundHttpException("L'evénement d'id " . $idEvent . " n'existe pas.");
        }
        $essence = new Essence();

        $eventContent = $essence->replace($event->getEventText(), function ($media) {
            return <<<HTML
		<div class="well well-lg col-lg-6 col-lg-offset-3 col-md-8 col-md-2 col-sm-12">
			<p class="text-primary-blue text-center">
				$media->title par
				<a href="$media->authorUrl" title="Accès à la chaine de $media->authorName">
					$media->authorName
				</a>
			 </p>
			<div class="embed-responsive embed-responsive-16by9">$media->html</div>
		</div>
HTML;
        });

        $form = $this->createForm(new DeleteEventType(), $event);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->remove($event);

            $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/hall/';
            foreach($event->getPhotos() as $photo) {
                $url = $photo->getPhotoUrl();
                $fs = new Filesystem();
                $fs->remove(array('symlink', $dir.'/'.$url));
                $em->remove($photo);
            }

            $em->flush();
            $this->addFlash('success', "L'évenement a été supprimé");

            return $this->redirect($this->generateUrl('agil_hall_homepage'));
        }

        return $this->render('AGILHallBundle:Event:event_delete.html.twig', array(
            'form' => $form->createView(),
            'event' => $event,
            'eventContent' => $eventContent
        ));
    }
}
