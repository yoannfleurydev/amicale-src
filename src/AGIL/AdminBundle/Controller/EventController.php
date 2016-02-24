<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    public function adminEventAddAction()
    {

        return $this->render('AGILAdminBundle:Event:admin.event.add.html.twig');
    }
}
