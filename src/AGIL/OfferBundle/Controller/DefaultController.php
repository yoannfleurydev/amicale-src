<?php

namespace AGIL\OfferBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OfferController extends Controller
{
    public function offerAction($page)
    {
        return $this->render('AGILOfferBundle:Offer:offer.html.twig');
    }

    public function offerAddAction(Request $request, $id)
    {
        return $this->render('AGILOfferBundle:Offer:offer_add.html.twig');
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
