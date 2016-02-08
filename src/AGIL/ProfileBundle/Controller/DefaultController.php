<?php

namespace AGIL\ProfileBundle\Controller;

use AGIL\ProfileBundle\Form\ProfileEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
    public function indexAction() {
//        // Vérifier si l'utilisateur est connecté
//        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
//            throw $this->createAccessDeniedException();
//        }

        $user = $this->getUser();

        return $this->render('AGILProfileBundle:Default:index.html.twig', array('user' => $user,));
    }

    public function showAction($id) {
        $userRepository = $this->getDoctrine()->getManager()->getRepository('AGILUserBundle:AgilUser');
        $profileSkillsCategoryRepository =
            $this->getDoctrine()->getManager()->getRepository('AGILProfileBundle:AgilProfileSkillsCategory');
        $tagRepository  = $this->getDoctrine()->getManager()->getRepository('AGILDefaultBundle:AgilTag');
        $skillRepository = $this->getDoctrine()->getManager()->getRepository('AGILProfileBundle:AgilSkill');

        $user = $userRepository->find($id);
        $profileSkillsCategories = $profileSkillsCategoryRepository->findAll();
        $tags = $tagRepository->findAll();
        $skills = $skillRepository->findBy(array('user' => $user));

        return $this->render('AGILProfileBundle:Default:index.html.twig',
            array(
                'user' => $user,
                'profileSkillsCategories' => $profileSkillsCategories,
                'tags' => $tags,
                'skills' => $skills
            )
        );
    }

    public function editAction(Request $request) {

        // EntityManager
        $userManager = $this->get('fos_user.user_manager');

        /*
        // Récupération de l'objet AgilUser dont l'id est $id
        $agilUser = $this->$em->getgetRepository('AGILDefaultBundle:AgilUser')->find($id)
        ;

        if (null === $agilUser) {
            throw new NotFoundHttpException("L'utilisateur n'existe pas.");
        }
        */

        $user = $this->getUser();

        $form = $this->createForm(new ProfileEditType(), NULL);
        $form->get('username')->setData($user->getUsername());
        $form->get('email')->setData($user->getEmail());

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            if ($form->get('password')->getData() != null and $form->get('password')->getData() == $form->get('passwordConfirm')->getData()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $pass = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());
                $user->setPassword($pass);
            }
            if ($form->get('username')->getData() == null or $form->get('password')->getData() == null
            or $form->get('email')->getData() == null or $form->get('password')->getData() != $form->get('passwordConfirm')->getData()) {
                $this->addFlash('notice','Erreur ! Champs vides ou mal remplies !');
                return $this->render('AGILProfileBundle:Default:edit.html.twig', array('user' => $user
                , 'form' => $form->createView()));
            } else {
                $userManager->updateUser($user);
                return $this->redirect($this->generateUrl('agil_profile'));
            }
        }
        return $this->render('AGILProfileBundle:Default:edit.html.twig', array('user' => $user
        , 'form' => $form->createView()));

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
