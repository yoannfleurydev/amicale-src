<?php

namespace AGIL\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILChatBundle:Default:index.html.twig');
    }
}
