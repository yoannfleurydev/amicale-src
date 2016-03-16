<?php

namespace AGIL\OfferBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $offers = $em->getRepository('AGILOfferBundle:AgilOffer')->findBy(array(),array('offerPostDate' => 'DESC'));

        return $this->render('AGILOfferBundle:Default:index.html.twig', array(
            'offers' => $offers
        ));
    }
}
