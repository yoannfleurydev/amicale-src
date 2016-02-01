<?php

namespace AGIL\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILSearchBundle:Default:index.html.twig');
    }
}
