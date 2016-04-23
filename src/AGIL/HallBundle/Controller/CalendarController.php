<?php

namespace AGIL\HallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\VarDumper\VarDumper;
use AGIL\SearchBundle\Form\SearchType;

class CalendarController extends Controller
{
    // Récupère les données des événements entre 2 dates
    // pour le calendrier : Requête appelée via Ajax
    public function getCalendarDataAction(Request $req)
    {
        if ($req->isXMLHttpRequest()) {

            $start = $req->get('start');
            $end   = $req->get('end');

            $em = $this->getDoctrine()->getManager();
            $events = $em->getRepository('AGILHallBundle:AgilEvent')->getEventDataStartEnd($start, $end);

            return new JsonResponse($events);
        }
        return new Response("Erreur !");
    }

    public function showCalendarAction()
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        return $this->render('AGILHallBundle:Calendar:index.html.twig',
            array('formSearchBar' => $formSearchBar->createView()));
    }
}
