<?php

namespace AGIL\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILDefaultBundle:Default:index.html.twig');
    }
}
