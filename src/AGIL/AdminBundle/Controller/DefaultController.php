<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AGIL\SearchBundle\Form\SearchType;

class DefaultController extends Controller
{
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $count_users = $em->getRepository("AGILUserBundle:AgilUser")->getCount();

        $qb2 = $em->createQueryBuilder();
        $qb2->select('count(subject.forumSubjectId)');
        $qb2->from('AGILForumBundle:AgilForumSubject','subject');
        $count_subjects = $qb2->getQuery()->getSingleScalarResult();

        $count_events = $em->getRepository('AGILHallBundle:AgilEvent')->getCountEvents();

        $count_offers = $em->getRepository('AGILOfferBundle:AgilOffer')->getCountOffers();

        return $this->render('AGILAdminBundle:Default:admin.html.twig', array(
            'nbUsers' => $count_users,
            'nbSubjects' => $count_subjects,
            'nbEvents' => $count_events,
            'nbOffers' => $count_offers,
            'formSearchBar' => $formSearchBar->createView()
        ));
    }
}
