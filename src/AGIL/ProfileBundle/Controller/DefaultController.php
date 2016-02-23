<?php

namespace AGIL\ProfileBundle\Controller;

use AGIL\ProfileBundle\Form\ProfileEditType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller
{
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

    // TODO Optimisation des conditions possible.
    public function editAction(Request $request) {
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->getUser();

        $profileSkillsCategoryRepository = $this->getDoctrine()->getManager()
            ->getRepository('AGILProfileBundle:AgilProfileSkillsCategory');
        $tagRepository  = $this->getDoctrine()->getManager()->getRepository('AGILDefaultBundle:AgilTag');
        $skillRepository = $this->getDoctrine()->getManager()->getRepository('AGILProfileBundle:AgilSkill');

        $profileSkillsCategories = $profileSkillsCategoryRepository->findAll();
        $tags = $tagRepository->findAll();
        $skills = $skillRepository->findBy(array('user' => $user));

        $data = array(
            'profileSkillsCategories' => $profileSkillsCategories,
            'tags' => $tags,
            'skills' => $skills
        );

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

            $profilePicture = $form->get('userProfilePictureUrl')->getData();
            if ($profilePicture != null) {
                // Générer le nom du fichier image
                $profilePicFileName = 'profile' . $user->getUserId() . '.' . $profilePicture->guessExtension();
                $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/profile';

                // insérer ici une condition pour vérifier le format du fichier
                $profilePicture->move($dir, $profilePicFileName);
                $user->setUserProfilePictureUrl($profilePicFileName);
                $userManager->updateUser($user);
            }

            $cv = $form->get('userCVUrl')->getData();
            if($cv != null) {
                // Générer le nom du fichier
                $cvFileName = md5(uniqid()).'.'.$cv->guessExtension();
                $dir = $this->container->getParameter('kernel.root_dir') . '/../web/files/cv';

                // TODO insérer ici une condition pour vérifier le format du fichier
                $cv->move($dir, $cvFileName);
                $user->setUserCVUrl($cvFileName);
                $userManager->updateUser($user);

            }

            if ($form->get('password')->getData() != null && $form->get('password')->getData() == $form->get('passwordConfirm')->getData()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $pass = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());
                $user->setPassword($pass);
            }

            if (($form->get('password')->getData() != null && $form->get('passwordConfirm')->getData() == null)
                || ($form->get('passwordConfirm')->getData() != null && $form->get('password')->getData() == null)
                || ($form->get('passwordConfirm')->getData() != $form->get('password')->getData())) {
                $this->addFlash('warning', 'Erreur ! Les mots de passe ne correspondent pas !');

                return $this->render('AGILProfileBundle:Default:edit.html.twig',
                    array(
                        'user' => $user,
                        'form' => $form->createView()
                    )
                );
            }

            foreach($profileSkillsCategories as $profileSkillsCategory) {
                foreach($tags as $tag) {
                    if ($tag->getSkillCategory() == $profileSkillsCategory) {
                        foreach($skills as $skill) {
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

                return $this->render('AGILProfileBundle:Default:edit.html.twig',
                    array(
                        'user' => $user,
                        'form' => $form->createView()
                    )
                );
            } else {
                $userManager->updateUser($user);
                $this->addFlash('success', 'Profil modifié.');
                return $this->redirect($this->generateUrl('agil_profile_id', array('id' => $user->getId())));
            }
        }


        return $this->render('AGILProfileBundle:Default:edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'data' => $data
        ));
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
