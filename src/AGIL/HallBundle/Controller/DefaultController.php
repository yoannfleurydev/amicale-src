<?php

namespace AGIL\HallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILHallBundle:Default:index.html.twig');
    }
}
