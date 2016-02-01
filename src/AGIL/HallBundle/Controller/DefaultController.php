<?php

namespace AGIL\HallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILHallBundle:Default:index.html.twig');
    }
}
