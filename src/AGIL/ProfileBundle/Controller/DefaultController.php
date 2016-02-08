<?php

namespace AGIL\ProfileBundle\Controller;

use AGIL\ProfileBundle\Form\ProfileEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction() {
        $user = $this->getUser();

        return $this->render('AGILProfileBundle:Default:index.html.twig', array('user' => $user));
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

        $userManager = $this->get('fos_user.user_manager');
        $user = $this->getUser();

        // Création d'un formulaire lié à aucune entité
        $form = $this->createForm(new ProfileEditType(), null); // <=> $form = $this->get('form.factory')->create(new ProfileEditType(), null);

        // pré remplissage des champs
        $form->get('username')->setData($user->getUsername());
        $form->get('email')->setData($user->getEmail());
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            $profilePicture = $form->get('userProfilePictureUrl')->getData();
//            var_dump($profilePicture);

            // Générer le nom du fichier image
            $fileName = 'profile' . $user->getUserId() . "." . $profilePicture->guessExtension();

            // Upload de l'image
            $dir = $this->container->getParameter('kernel.root_dir').'/../web/img/profile';

            // insérer ici une codition pour vérifier le format des fichiers
            $profilePicture->move($dir, $fileName);
            $user->setUserProfilePictureUrl($fileName);
            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());

            if ($form->get('password')->getData() != null && $form->get('password')->getData() == $form->get('passwordConfirm')->getData()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $pass = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());
                $user->setPassword($pass);
            }

            if ($form->get('username')->getData() == null || $form->get('password')->getData() == null || $form->get('email')->getData() == null || $form->get('password')->getData() != $form->get('passwordConfirm')->getData()) {
                $this->addFlash('notice', 'Erreur ! Champs vides ou mal remplies !');
                return $this->render('AGILProfileBundle:Default:edit.html.twig',array(
                    'user' => $user,
                    'form' => $form->createView()));
            } else {
                $userManager->updateUser($user);
                return $this->redirect($this->generateUrl('agil_profile'));
            }
        }

        return $this->render('AGILProfileBundle:Default:edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView()));
    }

    /**
     * Vérifie si une image de profil est valide
     *
     * @param UploadedFile $picture
     * @return bool
     */
//    private function isValidProfilePicture(UploadedFile $picture) {
//        $allowedExtensions = array('jpeg', 'png'); // Format à ajouter si besoin...
//        if (!in_array($picture->guessExtension(), $allowedExtensions)) {
//            return false;
//        }
//
//        return true;
//    }

}
