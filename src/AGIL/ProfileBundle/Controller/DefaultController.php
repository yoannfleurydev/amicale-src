<?php

namespace AGIL\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AGILProfileBundle:Default:index.html.twig');
    }

    public function showProfileAction($id)
    {

    }

    public function editAction($id, Request $request)
    {
        // EntityManager
        $em = $this->getDoctrine()->getManager();

        // Récupération de l'objet AgilUser dont l'id est $id
        $agilUser = $this->$em->getgetRepository('AGILDefaultBundle:AgilUser')->find($id)
        ;

        if (null === $agilUser) {
            throw new NotFoundHttpException("L'utilisateur n'existe pas.");
        }

        // Création du formulaire
        $form = $this->get('form.factory')->createBuilder('form', $agilUser)
            ->add('lastName',           'text')
            ->add('firstName',          'text')
            ->add('birthdayDate',       'date')
            ->add('cvUrl',              'url', array('required' => 'false'))
            ->add('profilePictureUrl',  'url', array('required' => 'false'))
            ->getForm()
        ;

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Profil modifié avec succès.');

            return $this->redirect($this->generateUrl('agil_profile'));
        }


    }


}
