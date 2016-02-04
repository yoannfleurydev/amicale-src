<?php

namespace AGIL\ProfileBundle\Controller;

use AGIL\DefaultBundle\Entity\AgilUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        return $this->render('AGILProfileBundle:Default:index.html.twig', array(
            'user' => $user,
        ));
    }

    public function showProfileAction($id)
    {
        
    }

    public function editAction(Request $request)
    {
        /*
        // EntityManager
        $em = $this->getDoctrine()->getManager();

        // Récupération de l'objet AgilUser dont l'id est $id
        $agilUser = $this->$em->getgetRepository('AGILDefaultBundle:AgilUser')->find($id)
        ;

        if (null === $agilUser) {
            throw new NotFoundHttpException("L'utilisateur n'existe pas.");
        }*/

        $agilUser = new AgilUser();

        $agilUser->setFirstName('MyfirstName');
        $agilUser->setLastName('MylastName');
        $agilUser->setUsername('MyUserName');
        $agilUser->setEmail('example@email.com');
        $agilUser->setCvUrl('mywebsite.com/cv.pdf');
        $agilUser->setProfilePictureUrl('mywebsite.com/pic.jpg');

        $form = $this->createForm("agilUser")
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('cvUrl', TextType::class)
            ->add('profilePictureUrl', TextType::class)
            ->getForm();

        return $this->render('AGILProfileBundle:Default:index.html.twig', array(
            'user' => $agilUser,
//            'form' => $form->createView()
        ));
/*
        // Création du formulaire
        $form = $this->get('form.factory')->createBuilder('form', $agilUser)
            ->add('firstName',          'text')
            ->add('lastName',           'text')
            ->add('username',           'text')
            ->add('email',              'text')
            ->add('birthdayDate',       'date')
            ->add('cvUrl',              'url', array('required' => 'false'))
            ->add('profilePictureUrl',  'url', array('required' => 'false'))
            ->getForm()
        ;

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Profil modifié avec succès.');

            return $this->redirect($this->generateUrl('agil_profile'));
        }*/

    }

}
