<?php

namespace AGIL\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILProfileBundle:User:index.html.twig');
    }
}