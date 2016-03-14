<?php

namespace AGIL\OfferBundle\Controller;

use AGIL\DefaultBundle\Entity\AgilTag;
use AGIL\OfferBundle\Entity\AgilOffer;
use AGIL\OfferBundle\Form\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class OfferController extends Controller
{
    public function offerAction($id)
    {
        return $this->render('AGILOfferBundle:Offer:offer.html.twig');
    }

    public function offerAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $offer = new AgilOffer();
        $form = $this->createForm(new OfferType(), $offer);

        $form->handleRequest($request);
        if ($form->isValid()) {
            // insert tags
            $tagsArrayString = explode(" ", $form->get('tags')->getData());
            $tagsManager = $this->get('agil_default.tags');
            foreach ($tagsArrayString as $tag) {
                $tagsManager->insertTag($tag);
            }
            $tagsManager->insertDone();
            $offer->setTags($em->getRepository("AGILDefaultBundle:AgilTag")->findByTagName($tagsArrayString));

            $em->persist($offer);
            $em->flush();

            $this->redirectToRoute('agil_offer_homepage');
        }

        return $this->render('AGILOfferBundle:Offer:offer_add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function offerEditAction(Request $request, $idCrypt)
    {
        return $this->render('AGILOfferBundle:Offer:offer_edit.html.twig');
    }

    /**
     * fonction d'envoie de mail
     * @param $subject
     * @param $body
     * @param $to
     */
    function sendMail($subject, $body, $to) {
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

        if(mail($to, $subject, $message, $headers))
        {
        }
        else
        {
            $this->addFlash('warning', 'Erreur lors de l\'envois de l\'email.');
        }

    }

}
