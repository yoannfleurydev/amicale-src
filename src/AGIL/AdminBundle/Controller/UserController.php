<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function adminUserAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();
        $qb->select('count(agil_user.id)');
        $qb->from('AGILUserBundle:AgilUser','agil_user');

        $maxUsers = 25;
        $users_count = $qb->getQuery()->getSingleScalarResult();

        $pagination = array(
            'page' => $page,
            'route' => 'agil_admin_user',
            'pages_count' => ceil($users_count / $maxUsers),
            'route_params' => array()
        );

        $users = $em->getRepository('AGILUserBundle:AgilUser')->getList($page, $maxUsers);

        return $this->render('AGILAdminBundle:User:admin_user.html.twig', array(
            'users' => $users,
            'pagination' => $pagination
        ));
    }
}
