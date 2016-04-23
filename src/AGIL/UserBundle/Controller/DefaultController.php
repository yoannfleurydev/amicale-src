<?php

namespace AGIL\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AGIL\SearchBundle\Form\SearchType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        return $this->render('AGILUserBundle::layout.html.twig',array(
            'formSearchBar' => $formSearchBar->createView()
        ));
    }
}
