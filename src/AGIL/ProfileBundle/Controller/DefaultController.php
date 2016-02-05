<?php

namespace AGIL\ProfileBundle\Controller;

use AGIL\UserBundle\Entity\AgilUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
    public function indexAction() {
        // Vérifier si l'utilisateur est connecté
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        return $this->render('AGILProfileBundle:Default:index.html.twig', array('user' => $user,));
    }

    public function showAction($id) {
        $userRepository = $this->getDoctrine()->getManager()->getRepository('AGILUserBundle:AgilUser');

        $user = $userRepository->find($id);

        return $this->render('AGILProfileBundle:Default:index.html.twig', array('user' => $user,));
    }

    public function editAction() {
        /*
        // EntityManager
        $em = $this->getDoctrine()->getManager();

        // Récupération de l'objet AgilUser dont l'id est $id
        $agilUser = $this->$em->getgetRepository('AGILDefaultBundle:AgilUser')->find($id)
        ;

        if (null === $agilUser) {
            throw new NotFoundHttpException("L'utilisateur n'existe pas.");
        }*/

        // Vérifier si l'utilisateur est connecté
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        return $this->render('AGILProfileBundle:Default:edit.html.twig', array('user' => $user,));

        /*$form = $this->createForm("agilUser")
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('cvUrl', TextType::class)
            ->add('profilePictureUrl', TextType::class)
            ->getForm();*/

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
