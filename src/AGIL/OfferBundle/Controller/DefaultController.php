<?php

namespace AGIL\OfferBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AGIL\SearchBundle\Form\SearchType;
use Symfony\Component\Validator\Constraints\DateTime;


class DefaultController extends Controller
{
    const MAX_OFFERS = 10;

    public function indexAction($page)
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $em = $this->getDoctrine()->getManager();
        //$offers = $em->getRepository('AGILOfferBundle:AgilOffer')->findBy(array('offerPublish' => true),array('offerPostDate' => 'DESC'));

        $offerCount = $em->getRepository('AGILOfferBundle:AgilOffer')->getCountOffers();

        // On vérifie que le nombre de pages spécifié dans l'URL n'est pas absurde
        if(($offerCount == 0 && $page != 1) ||
            ($offerCount != 0 && $page > ceil($offerCount / DefaultController::MAX_OFFERS) || $page <= 0)  ){
            throw new NotFoundHttpException("Erreur dans le numéro de page");
        }

        $pagination = array(
            'page' => $page,
            'route' => 'agil_offer_homepage',
            'pages_count' => ceil($offerCount / DefaultController::MAX_OFFERS),
            'route_params' => array()
        );

        $offers = $em->getRepository('AGILOfferBundle:AgilOffer')->getOffersByPage($page, DefaultController::MAX_OFFERS);

        $date = new \DateTime();
        foreach($offers as $offer) {
            if($offer->getOfferExpirationDate()<$date) {
                $em->remove($offer);
            }
        }

        $em->flush();

        return $this->render('AGILOfferBundle:Default:index.html.twig', array(
            'offers' => $offers,
            'pagination' => $pagination,
            'formSearchBar' => $formSearchBar->createView()
        ));
    }
}
