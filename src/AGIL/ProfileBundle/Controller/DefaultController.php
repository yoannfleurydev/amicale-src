<?php

namespace AGIL\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILProfileBundle:Default:index.html.twig');
    }

    public function showProfileAction($id)
    {

    }

    public function editAction()
    {

    }


}
