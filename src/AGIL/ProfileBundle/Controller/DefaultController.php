<?php

namespace AGIL\ProfileBundle\Controller;

use AGIL\ProfileBundle\Form\ProfileEditType;
use AGIL\UserBundle\Entity\AgilUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use AGIL\SearchBundle\Form\SearchType;

class DefaultController extends Controller {

    public function profileAction($id, Request $request) {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $userRepository = $this->getDoctrine()->getManager()->getRepository('AGILUserBundle:AgilUser');
        $profileSkillsCategoryRepository = $this->getDoctrine()->getManager()->getRepository('AGILProfileBundle:AgilProfileSkillsCategory');
        $tagRepository = $this->getDoctrine()->getManager()->getRepository('AGILDefaultBundle:AgilTag');
        $skillRepository = $this->getDoctrine()->getManager()->getRepository('AGILProfileBundle:AgilSkill');

        // Utilisateur courant
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->getUser();

        if (isset($user) && $user->getUserId() == $id) {
            $profileSkillsCategories = $profileSkillsCategoryRepository->findAll();
            $tags = $tagRepository->findAll();
            $skills = $skillRepository->findBy(array('user' => $user));

            $data = array('profileSkillsCategories' => $profileSkillsCategories, 'tags' => $tags, 'skills' => $skills);

            // Création d'un formulaire lié à aucune entité
            $form = $this->createForm(new ProfileEditType($data), null);

            // Remplissage des champs qui ont une valeur.
            $form->get('username')->setData($user->getUsername());
            $form->get('email')->setData($user->getEmail());
            $form->get('userCVUrlVisibility')->setData($user->getUserCVUrlVisibility());


            // S'exécute à la reception du formmulaire.
            if ($request->getMethod() == Request::METHOD_POST) {
                $form->handleRequest($request);

                $user->setUsername($form->get('username')->getData());
                $user->setEmail($form->get('email')->getData());
                $user->setUserCVUrlVisibility($form->get('userCVUrlVisibility')->getData());

                $profilePicture = $form->get('userProfilePictureUrl')->getData();
                // Changement de la photo de profil
                if ($profilePicture != null && $profilePicture != "") {
                    // On vérifie le format de la photo
                    if ($profilePicture->guessExtension() != "jpeg" && $profilePicture->guessExtension() != "png" && $profilePicture->guessExtension() != "gif") {
                        $this->addFlash('warning', 'Erreur ! Le format de l\'image ne convient pas ! (formats autorisés: jpeg,png,gif)');

                        return $this->redirect($this->generateUrl('agil_profile_edit', array('id' => $user->getId())));
                    } // On vérifie la taille du fichier
                    else if ($profilePicture->getClientSize() > 1024000) {
                        $this->addFlash('warning', 'Erreur ! La taille de l\'image dépasse la limite ! (limite autorisée: 1Mo)');

                        return $this->redirect($this->generateUrl('agil_profile_edit', array('id' => $user->getId())));
                    }

                    $this->editProfilPicture($profilePicture, $user);
                }

                if ($form->get('userDeleteProfilePicture')->getData()) {
                    $user->setUserProfilePictureUrl(AgilUser::DEFAULT_PROFILE_PICTURE);
                }

                $cv = $form->get('userCVUrl')->getData();
                if ($cv != null || $cv != "") {
                    // On vérifie le format du CV
                    if ($cv->guessExtension() != "pdf") {
                        $this->addFlash('warning', 'Erreur ! Le format du CV ne convient pas ! (format autorisé: pdf)');

                        return $this->redirect($this->generateUrl('agil_profile_edit', array('id' => $user->getId())));
                    } // On vérifie la taille du fichier
                    else if ($cv->getClientSize() > 3072000) {
                        $this->addFlash('warning', 'Erreur ! La taille du CV dépasse la limite ! (limite autorisée: 3Mo)');

                        return $this->redirect($this->generateUrl('agil_profile_edit', array('id' => $user->getId())));
                    }

                    $this->editProfilCV($cv, $user);
                }

                if ($form->get('oldPassword')->getData() != null) {
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $encoded_pass = $encoder->encodePassword($form->get('oldPassword')->getData(), $user->getSalt());

                    if ($encoded_pass == $user->getPassword() && $form->get('password')->getData() != null && $form->get('password')->getData() == $form->get('passwordConfirm')->getData()) {

                        // Si la longueur du mot de passe est inférieure à 5 caractères, alors on affiche un message et on
                        // ne change rien à l'utilisateur.
                        if (strlen($form->get('password')->getData()) <= 5) {
                            $this->addFlash('warning', 'Pour votre sécurité, votre mot de passe doit faire plus de 5 
                        caractères. Nous conseillons l\'utilisation de caractères alphanumériques et de caractères 
                        spéciaux.');

                            return $this->redirectToRoute(
                                'agil_profile_id',
                                array('id' => $this->getUser()->getUserId())
                            );
                        } else {
                            $encoder = $factory->getEncoder($user);
                            $pass = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());
                            $user->setPassword($pass);
                        }
                    } else {
                        $this->addFlash('warning', 'Erreur ! Les mots de passe ne correspondent pas !');

                        return $this->redirect($this->generateUrl('agil_profile_edit'));
                    }
                } else if ($form->get('password')->getData() != null || $form->get('passwordConfirm')->getData() != null) {
                    $this->addFlash('warning', 'Erreur ! L\'ancien mot de passe doit être entré et correct !');

                    return $this->redirect($this->generateUrl('agil_profile_edit'));
                }

                foreach ($profileSkillsCategories as $profileSkillsCategory) {
                    foreach ($tags as $tag) {
                        if ($tag->getSkillCategory() == $profileSkillsCategory) {
                            foreach ($skills as $skill) {
                                if ($skill->getTag() == $tag) {
                                    $skill->setSkillLevel($form->get('tag' . $tag->getTagId())->getData());
                                    $this->getDoctrine()->getManager()->persist($skill);
                                }
                            }
                        }
                    }
                }

                $this->getDoctrine()->getManager()->flush();

                if ($form->get('username')->getData() == null || $form->get('email')->getData() == null) {
                    $this->addFlash('warning', 'Erreur ! Champs vides ou mal remplis !');

                    return $this->render('AGILProfileBundle:Default:index.html.twig', array(
                        'user' => $user, 'form' => $form->createView(),
                        'formSearchBar' => $formSearchBar->createView()));
                } else {
                    $userManager->updateUser($user);
                    $this->addFlash('success', 'Profil modifié.');

                    $logger = $this->get('service_profile.logger');
                    $logger->info("[Profil modifié] ".$this->getUser()->getUserFirstName()." "
                        .$this->getUser()->getUserLastName()." (" .$this->getUser()->getUsername(). ")");

                    return $this->redirect($this->generateUrl('agil_profile_id', array('id' => $user->getId())));
                }
            }


            return $this->render(
                'AGILProfileBundle:Default:edit.html.twig',
                array('user' => $user,
                    'form' => $form->createView(),
                    'data' => $data,
                    'profileSkillsCategories' => $profileSkillsCategories,
                    'tags' => $tags,
                    'skills' => $skills,
                    'formSearchBar' => $formSearchBar->createView()
                )
            );
        } else {
            $user = $userRepository->find($id);
            $profileSkillsCategories = $profileSkillsCategoryRepository->findAll();
            $tags = $tagRepository->findAll();
            $skills = $skillRepository->findBy(array('user' => $user));

            return $this->render(
                'AGILProfileBundle:Default:index.html.twig',
                array(
                    'user' => $user,
                    'profileSkillsCategories' => $profileSkillsCategories,
                    'tags' => $tags,
                    'skills' => $skills,
                    'formSearchBar' => $formSearchBar->createView())
            );
        }
    }

    private function editProfilPicture($profilePicture, $user) {
        // Générer le nom du fichier image
        $profilePicFileName = 'profile' . $user->getUserId() . '.' . $profilePicture->guessExtension();
        $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/profile';

        // supprime l'ancienne photo en locale
        $imgOld = $user->getUserProfilePictureUrl();

        if ($imgOld !== AgilUser::DEFAULT_PROFILE_PICTURE) {
            $fs = new Filesystem();
            $fs->remove(array('symlink', $dir . '/' . $imgOld));
        }

        // upload de la photo
        $profilePicture->move($dir, $profilePicFileName);

        $user->setUserProfilePictureUrl($profilePicFileName);
        $this->getDoctrine()->getManager()->flush();
    }

    private function editProfilCV($cv, $user) {
        // Générer le nom du fichier
        $cvFileName = md5(uniqid()) . '.' . $cv->guessExtension();
        //$cvFileName = 'cv' . $user->getUserId() . '.' . $cv->guessExtension();
        $dir = $this->container->getParameter('kernel.root_dir') . '/../web/files/cv';

        // supprime l'ancien CV
        $cvOld = $user->getUserCVUrl();
        $fs = new Filesystem();
        $fs->remove(array('symlink', $dir . '/' . $cvOld));

        // upload du CV
        $cv->move($dir, $cvFileName);

        $user->setUserCVUrl($cvFileName);
        $this->getDoctrine()->getManager()->flush();
    }

    /**
     * La méthode deleteAction permet de supprimer le compte de l'utilisateur courant s'il utilise le lien dédié sur
     * la page de son profil.
     */
    public function deleteAction() {

        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        if (empty($this->getUser()) || $this->getUser() === null) {
            $this->addFlash('danger', 'Vous ne pouvez pas accéder à cette partie');

            return $this->redirect($this->generateUrl('agil_default_homepage'));
        }

        $em = $this->getDoctrine()->getManager();

        $eventRepo = $em->getRepository("AGILHallBundle:AgilEvent");
        $events = $eventRepo->findBy(array('user' => $this->getUser()));

        foreach ($events as $event) {
            $em->remove($event);
        }
        $this->get('fos_user.user_manager')->deleteUser($this->getUser());

        $em->flush();

        $this->addFlash('danger', 'Votre compte a bien été supprimé.');

        $logger = $this->get('service_profile.logger');
        $logger->info("[Profil supprimé] ".$this->getUser()->getUserFirstName()." "
            .$this->getUser()->getUserLastName()." (" .$this->getUser()->getUsername(). ")");

        return $this->redirect($this->generateUrl('agil_default_homepage'));
    }
}
