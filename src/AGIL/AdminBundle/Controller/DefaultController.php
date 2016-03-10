<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $count_users = $em->getRepository("AGILUserBundle:AgilUser")->getCount();

        $qb2 = $em->createQueryBuilder();
        $qb2->select('count(subject.forumSubjectId)');
        $qb2->from('AGILForumBundle:AgilForumSubject','subject');
        $count_subjects = $qb2->getQuery()->getSingleScalarResult();

        $count_events = $em->getRepository('AGILHallBundle:AgilEvent')->getCountEvents();

        return $this->render('AGILAdminBundle:Default:admin.html.twig', array(
            'nbUsers' => $count_users,
            'nbSubjects' => $count_subjects,
            'nbEvents' => $count_events
        ));
    }
}
