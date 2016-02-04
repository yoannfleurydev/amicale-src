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
        $count = $qb->getQuery()->getSingleScalarResult();

        return $this->render('AGILAdminBundle:Default:admin.html.twig',
            array('nbUsers' => $count)
        );
    }
}
