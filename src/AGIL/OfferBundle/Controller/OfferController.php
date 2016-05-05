<?php

namespace AGIL\OfferBundle\Controller;

use AGIL\DefaultBundle\Entity\AgilTag;
use AGIL\OfferBundle\Entity\AgilOffer;
use AGIL\OfferBundle\Form\EditOfferType;
use AGIL\OfferBundle\Form\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use AGIL\SearchBundle\Form\SearchType;


class OfferController extends Controller
{
    public function offerAction($id)
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('AGILOfferBundle:AgilOffer')->find($id);

        if ($offer == null) {
            $this->addFlash('warning', 'Cette annonce n\'existe pas.');
            return $this->redirect($this->generateUrl('agil_offer_homepage'));
        } elseif (!$offer->getOfferPublish()) {
            $this->addFlash('warning', 'Cette annonce n\'est pas encore publiée.');
            return $this->redirect($this->generateUrl('agil_offer_homepage'));
        }

        return $this->render('AGILOfferBundle:Offer:offer.html.twig', array(
            'offer' => $offer,
            'formSearchBar' => $formSearchBar->createView()
        ));
    }

    /**
     * Ajout d'annonce
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function offerAddAction(Request $request)
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $em = $this->getDoctrine()->getManager();
        $offer = new AgilOffer();
        $form = $this->createForm(new OfferType(), $offer);
        $form->get('expireAt')->setData('P3M');

        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $form->get('offerPdfUrl')->getData();
            if ($file == null && $form->get('offerText')->getData() == null) {
                $this->addFlash('warning', 'Il faut au moins remplir la description ou joindre un fichier à l\'annonce !');
                return $this->redirect($this->generateUrl('agil_offer_add'));
            }

            // insert cv
            if ($file != null && $file != "") {
                if ($file->guessExtension() != "pdf") {
                    $this->addFlash('warning', 'Erreur ! Le format du fichier ne convient pas ! (format autorisé: pdf)');
                    return $this->redirect($this->generateUrl('agil_offer_add'));
                } else if ($file->getClientSize() > 3072000) {
                    $this->addFlash('warning', 'Erreur ! La taille du fichier dépasse la limite ! (limite autorisée: 3Mo)');
                    return $this->redirect($this->generateUrl('agil_offer_add'));
                }

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/offer';
                $file->move($dir, $fileName);
                $offer->setOfferPdfUrl($fileName);
            }

            // insert tags
            $tagsArrayString = explode(" ", $form->get('tags')->getData());
            $tagsManager = $this->get('agil_default.tags');
            foreach ($tagsArrayString as $tag) {
                $tagsManager->insertTag($tag);
            }
            $tagsManager->insertDone();
            $offer->setTags($em->getRepository("AGILDefaultBundle:AgilTag")->findByTagName($tagsArrayString));

            // expiration
            $date = new \DateTime();
            $offer->setOfferExpirationDate($date->add(new \DateInterval($form->get('expireAt')->getData())));

            // send mail
            $url = $request->getSchemeAndHttpHost() . $this->generateUrl('agil_offer_edit', array('idCrypt' => $offer->getOfferRoute()));
            $subject = "Amicale GIL[Confirmation de l'annonce]";
            $message = "<p>Bonjour,</p>";
            $message .= "<p>Merci d'avoir créé une annonce sur Amicale GIL !</p>";
            $message .= "<p>Pour confirmer votre annonce sur le site, veuillez cliquer sur le lien suivant :</p>";
            $message .= "<p><strong><a href=\"$url\" TARGET=\"_blank\">Confirmer votre annonce</a></strong></p>";
            $message .= "<p><i>Il est important de garder ce mail pour pouvoir modifier ou supprimer cette annonce.</i></p>";
            $message .= "<p>Cordialement.</p>";
            $this->sendMail($subject, $message, $form->get('offerEmail')->getData());

            $em->persist($offer);
            $em->flush();

            $logger = $this->get('service_offer.logger');
            $logger->info("[Nouvelle Offre proposée] ".$offer->getOfferTitle()." (".$offer->getOfferEmail().")");

            $this->addFlash('success', 'Un mail de confirmation vous a été envoyé. Vous pouvez déposer une nouvelle 
            offre tout de suite ci-dessous.');
            return $this->redirect($this->generateUrl('agil_offer_add'));
        }

        return $this->render('AGILOfferBundle:Offer:offer_add.html.twig', array(
            'form' => $form->createView(),
            'formSearchBar' => $formSearchBar->createView()
        ));
    }

    public function offerEditAction(Request $request, $idCrypt)
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('AGILOfferBundle:AgilOffer')->findBy(array('offerRoute' => $idCrypt));

        if ($offer == null) {
            $this->addFlash('warning', 'Cette annonce n\'existe plus !');
            if (!empty($this->getUser())) {
                return $this->redirect($this->generateUrl('agil_offer_homepage'));
            } else {
                return $this->redirect($this->generateUrl('agil_offer_add'));
            }
        }

        $offer = $offer[0];

        if (!$offer->getOfferPublish()) {
            $this->addFlash('success', 'Votre annonce est maintenant publiée sur Amicale GIL.');
            $offer->setOfferPublish(true);
            $em->persist($offer);
            $em->flush();
            $logger = $this->get('service_offer.logger');
            $logger->info("[Nouvelle Offre validée] ".$offer->getOfferTitle()." (".$offer->getOfferEmail().")");
        }

        $form = $this->createForm(new EditOfferType(date_format($offer->getOfferExpirationDate(), 'Y')), $offer);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $form->get('offerPdfUrl')->getData();
            if ($file == null && $form->get('offerText')->getData() == null) {
                $this->addFlash('warning', 'Il faut au moins remplir la description ou joindre un fichier à l\'annonce !');
                return $this->redirect($this->generateUrl('agil_offer_edit',array('idCrypt' => $offer->getOfferRoute())));
            }

            // insert cv
            if ($file != null && $file != "") {
                if ($file->guessExtension() != "pdf") {
                    $this->addFlash('warning', 'Erreur ! Le format du fichier ne convient pas ! (format autorisé: pdf)');
                    return $this->redirect($this->generateUrl('agil_offer_edit',array('idCrypt' => $offer->getOfferRoute())));
                } else if ($file->getClientSize() > 3072000) {
                    $this->addFlash('warning', 'Erreur ! La taille du fichier dépasse la limite ! (limite autorisée: 3Mo)');
                    return $this->redirect($this->generateUrl('agil_offer_edit',array('idCrypt' => $offer->getOfferRoute())));
                }

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/offer';

                if ($offer->getOfferPdfUrl() != null) {
                    $fs = new Filesystem();
                    $fs->remove(array('symlink', $dir.'/'.$offer->getOfferPdfUrl()));
                }

                $file->move($dir, $fileName);
                $offer->setOfferPdfUrl($fileName);
            }

            // insert tags
            $tagsArrayString = explode(" ", $form->get('tags')->getData());
            $tagsManager = $this->get('agil_default.tags');
            foreach ($tagsArrayString as $tag) {
                $tagsManager->insertTag($tag);
            }
            $tagsManager->insertDone();
            $offer->removeTags();
            $em->persist($offer);
            $em->flush();

            $offer->setTags($em->getRepository("AGILDefaultBundle:AgilTag")->findByTagName($tagsArrayString));

            $em->persist($offer);
            $em->flush();
            $logger = $this->get('service_offer.logger');
            $logger->info("[Offre modifiée] ".$offer->getOfferTitle()." (".$offer->getOfferEmail().")");

            $this->addFlash('success','Annonce modifiée.');
            if (!empty($this->getUser())) {
                return $this->redirect($this->generateUrl('agil_offer_view', array('id' => $offer->getOfferId())));
            } else {
                return $this->redirect($this->generateUrl('agil_offer_edit', array('idCrypt' => $offer->getOfferRoute())));
            }
        }

        $tagArray = "";
        foreach($offer->getTags() as $tag) {
            $tagArray .= $tag->getTagName() . " ";
        }
        $form->get('tags')->setData($tagArray);

        return $this->render('AGILOfferBundle:Offer:offer_edit.html.twig', array(
            'offer' => $offer,
            'form' => $form->createView(),
            'formSearchBar' => $formSearchBar->createView()
        ));
    }

    public function offerDeleteAction(Request $request, $idCrypt) {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('AGILOfferBundle:AgilOffer')->findBy(array('offerRoute' => $idCrypt))[0];

        if ($offer == null) {
            $this->addFlash('success', 'Annonce déjà supprimée.');

            if (!empty($this->getUser())) {
                return $this->redirect($this->generateUrl('agil_offer_homepage'));
            } else {
                return $this->redirect($this->generateUrl('agil_offer_add'));
            }
        }

        if ($offer->getOfferPdfUrl() != null) {
            $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/offer';
            $fs = new Filesystem();
            $fs->remove(array('symlink', $dir.'/'.$offer->getOfferPdfUrl()));
        }

        $em->remove($offer);
        $em->flush();

        $logger = $this->get('service_offer.logger');
        $logger->info("[Offre supprimée] ".$offer->getOfferTitle()." (".$offer->getOfferEmail().")");

        $this->addFlash('success', 'Annonce supprimée.');

        if (!empty($this->getUser())) {
            return $this->redirect($this->generateUrl('agil_offer_homepage'));
        } else {
            return $this->redirect($this->generateUrl('agil_offer_add'));
        }
    }

    /**
     * fonction d'envoie de mail
     * @param $subject
     * @param $body
     * @param $to
     */
    function sendMail($subject, $body, $to)
    {
        $headers = 'From: amicale.gil@etu.univ-rouen.fr' . "\r\n";
        $headers .= "Reply-To: amicale.gil@etu.univ-rouen.fr\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"";

        $message = "
        <html>
            <head></head>
            <body>
                $body
            </body>
        </html>";

        if (mail($to, $subject, $message, $headers)) {
        } else {
            $this->addFlash('warning', 'Erreur lors de l\'envois de l\'email.');
        }

    }

}
