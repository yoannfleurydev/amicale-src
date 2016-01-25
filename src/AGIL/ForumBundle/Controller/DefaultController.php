<?php

namespace AGIL\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILForumBundle:Default:index.html.twig');
    }
}
