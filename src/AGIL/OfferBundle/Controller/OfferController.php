<?php

namespace AGIL\OfferBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILOfferBundle:Default:index.html.twig');
    }
}
