<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILAdminBundle:Default:index.html.twig');
    }
}
