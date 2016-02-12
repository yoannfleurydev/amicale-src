<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();
        $qb->select('count(user.id)');
        $qb->from('AGILUserBundle:AgilUser','user');
        $count_users = $qb->getQuery()->getSingleScalarResult();

        $qb2 = $em->createQueryBuilder();
        $qb2->select('count(subject.forumSubjectId)');
        $qb2->from('AGILForumBundle:AgilForumSubject','subject');
        $count_subjects = $qb2->getQuery()->getSingleScalarResult();

        return $this->render('AGILAdminBundle:Default:admin.html.twig', array(
            'nbUsers' => $count_users,
            'nbSubjects' => $count_subjects
        ));
    }
}
