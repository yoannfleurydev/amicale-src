<?php

namespace AGIL\AdminBundle\Controller;

use AGIL\AdminBundle\Form\UserAdminType;
use AGIL\ProfileBundle\Entity\AgilSkill;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use AGIL\UserBundle\Entity\AgilUser;
use AGIL\AdminBundle\Form\UserType;
use AGIL\AdminBundle\Form\SearchUserType;
use AGIL\AdminBundle\Form\UsersCSVType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserController extends Controller
{

    /**
     * retourne la liste des utilisateurs en fonction de ses droits
     * @param $page
     * @return Response
     */
    public function adminUserAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $maxUsers = 25;
        $users_count = $em->getRepository('AGILUserBundle:AgilUser')->getCountUsers();

        if (($users_count == 0 && $page != 1) ||
            ($users_count != 0 && $page > ceil($users_count / $maxUsers) || $page <= 0)
        ) {
            $this->addFlash('warning', 'Erreur dans le numéro de page');
            return $this->redirect($this->generateUrl('agil_admin_user'));
        }
        $pagination = array(
            'page' => $page,
            'route' => 'agil_admin_user',
            'pages_count' => ceil($users_count / $maxUsers),
            'route_params' => array()
        );

        $users = $em->getRepository('AGILUserBundle:AgilUser')->getListUsers($page, $maxUsers);
        $moderators = $em->getRepository('AGILUserBundle:AgilUser')->findByRole("ROLE_MODERATOR");
        $admins = $em->getRepository('AGILUserBundle:AgilUser')->findByRole("ROLE_ADMIN");

        $searchForm = $this->createForm(new SearchUserType(''));

        return $this->render('AGILAdminBundle:User:admin_user.html.twig', array(
            'users' => $users,
            'pagination' => $pagination,
            'moderators' => $moderators,
            'admins' => $admins,
            'nbMembers' => $users_count,
            'nbModerators' => count($moderators),
            'nbAdmins' => count($admins),
            'search' => $searchForm->createView(),
            'usersSearch' => null
        ));
    }

    /**
     * Augmentation des droits de l'utilisateurs
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminUserUpAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AGILUserBundle:AgilUser')->find($id);
        $newRole = "";

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id " . $id . " n'existe pas.");
        } else {
            if ($user->hasRole("ROLE_MODERATOR")) {
                $user->removeRole("ROLE_MODERATOR");
                $user->addRole('ROLE_ADMIN');
                $newRole = 'Administrateur';
            } else {
                $user->addRole("ROLE_MODERATOR");
                $newRole = 'Modérateur';
            }
            $em->persist($user);
            $em->flush();

            $username = $user->getUsername();
            $subject = "Amicale GIL[Augmentation de vos droits]";
            $message = "<p>Bonjour $username,</p>";
            $message .= "<p>vous êtes maintenant un $newRole sur le site Amicale GIL</p>";
            $message .= "<p>Cordialement</p>";
            $this->sendMail($subject, $message, $user->getEmail());
        }

        return $this->redirect($this->generateUrl('agil_admin_user'));
    }

    /**
     * Diminution des droits de l'utilisateur
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminUserDownAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AGILUserBundle:AgilUser')->find($id);
        $newRole = "";

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id " . $id . " n'existe pas.");
        } else {
            if ($user->hasRole("ROLE_MODERATOR")) {
                $user->removeRole("ROLE_MODERATOR");
                $newRole = "Membre";
            } else {
                $user->removeRole("ROLE_ADMIN");
                $user->addRole("ROLE_MODERATOR");
                $newRole = "Modérateur";
            }
            $em->persist($user);
            $em->flush();

            $username = $user->getUsername();
            $subject = "Amicale GIL[Pertes de vos droits]";
            $message = "<p>Bonjour $username,</p>";
            $message .= "<p>vous êtes maintenant un $newRole sur le site Amicale GIL</p>";
            $message .= "<p>Cordialement</p>";
            $this->sendMail($subject, $message, $user->getEmail());
        }

        return $this->redirect($this->generateUrl('agil_admin_user'));
    }

    /**
     * Suppression d'utilisateur
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminUserDeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AGILUserBundle:AgilUser')->find($id);

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id " . $id . " n'existe pas.");
        } else {
            $imgOld = $user->getUserProfilePictureUrl();
            if ($imgOld !== AgilUser::DEFAULT_PROFILE_PICTURE) {
                $fs = new Filesystem();
                $dir = $this->container->getParameter('kernel.root_dir') . '/../web/img/profile';
                $fs->remove(array('symlink', $dir . '/' . $imgOld));
            }
            $em->remove($user);
            $em->flush();

            $username = $user->getUsername();
            $subject = "Amicale GIL[Bannissement]";
            $message = "<p>Bonjour $username,</p>";
            $message .= "<p>vous avez été banni du site Amicale GIL</p>";
            $message .= "<p>Cordialement</p>";
            $this->sendMail($subject, $message, $user->getEmail());
        }

        return $this->redirect($this->generateUrl('agil_admin_user'));
    }

    public function adminUserSearchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if($request->isXmlHttpRequest())
        {
            $keyword = '';
            $keyword = $request->request->get('keyword');

            if($keyword != '')
            {
                $usersSearch = $em->getRepository('AGILUserBundle:AgilUser')->searchByName($keyword);

                return $this->render('AGILAdminBundle:User:admin_user_list.html.twig', array(
                    'usersSearch' => $usersSearch
                ));
            }
            else {
                return $this->render('AGILAdminBundle:User:admin_user_list.html.twig', array(
                    'usersSearch' => null
                ));
            }

            return $this->render('AGILAdminBundle:User:admin_user.html.twig', array(
                'usersSearch' => $users
            ));
        }
        else {
            return $this->redirect( $this->generateUrl('agil_admin_user') );
        }

    }

    /**
     * Ajout d'utilisateur
     * @param Request $request
     * @return Response
     */
    public function adminUserAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $form = $this->createForm(new UserType(), null);
        if ($user->hasRole("ROLE_ADMIN")) {
            $form = $this->createForm(new UserAdminType(), null);
        }

        $formCSV = $this->createForm(new UsersCSVType());

        $factory = $this->get('security.encoder_factory');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $formCSV->handleRequest($request);

            if ($formCSV->isValid()) {
                $this->addUserByCSVFile($formCSV, $em, $factory, $request);
            } elseif ($form->isValid()) {
                $this->addUserByForm($form, $em, $factory, $request);
            }
        }
        return $this->render('AGILAdminBundle:User:admin_user_add.html.twig', array(
            'form' => $form->createView(),
            'formCSV' => $formCSV->createView()
        ));
    }

    /**
     * Ajout d'utilisateur via le formulaire de base
     * @param $form
     * @param $em
     * @param $factory
     */
    function addUserByForm($form, $em, $factory, $request)
    {
        $email = $form->get('email')->getData();
        $user = $em->getRepository('AGILUserBundle:AgilUser')->findBy(array('email' => $email));

        if ($user == null) {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->createUser();
            $lastName = $form->get('name')->getData();
            $firstName = $form->get('firstName')->getData();
            $role = $form->get('role')->getData();
            if (strlen($lastName) >= 5 and strlen($firstName) >= 3) {
                $lastNameTmp = strtolower($lastName);
                $firstNameTmp = strtolower($firstName);
                $username = $lastNameTmp[0] . $lastNameTmp[1] . $lastNameTmp[2] .
                    $lastNameTmp[3] . $lastNameTmp[4] . $firstNameTmp[0] . $firstNameTmp[1] . $firstNameTmp[2];
            } else {
                $username = strtolower($firstName) . '.' . strtolower($lastName);
            }
            $cpt = 0;
            $usernameTmp = $username;
            while ($em->getRepository('AGILUserBundle:AgilUser')->findBy(array('username' => $username)) != null) {
                $username = $usernameTmp;
                $username .= $cpt;
                $cpt++;
            }

            $password = $this->generate_password();
            $encoder = $factory->getEncoder($user);
            $user->setUsername($username);
            $pass = $encoder->encodePassword($password, $user->getSalt());
            $user->setUserFirstName($firstName);
            $user->setUserLastName($lastName);
            $user->setEmail($email);
            $user->setPassword($pass);
            if ($role != 'ROLE_USER' or $role == null) {
                $user->addRole($role);
            }
            $user->setEnabled(1);

            $userManager->updateUser($user);
            $this->loadSkills($user, $em);

            $url = $request->getSchemeAndHttpHost();
            $subject = "Amicale GIL[Inscription]";
            $message = "<p>Bonjour $username,</p>";
            $message .= "<p>vous avez été invité sur le site <a href=\"$url\" TARGET=\"_blank\">Amicale GIL</a>.</p>";
            $message .= "<p>Pour vous connecter :</p>";
            $message .= "<p>Identifiant : $email</p><p>Mot de passe : $password</p>";
            $message .= "<p>Cordialement</p>";

            $this->sendMail($subject, $message, $email);
            $this->addFlash('success', 'Utilisateur enregistré.');
        } else {
            $this->addFlash('warning', 'Utilisateur déjà enregistré.');
        }
    }

    /**
     * Ajout d'utilisateur via un fichier .csv
     * @param $form
     * @param $em
     * @param $factory
     */
    function addUserByCSVFile($form, $em, $factory, $request)
    {
        $nbRegisters = 0;
        $file = $form['file']->getData();

        //$name = $file->getPathname();
        //echo $name;
        /*$dir = __DIR__.'/../../../../web/uploads';

        $file->move($dir, $name) ;*/
        $attr_user = array();
        $row = 1;
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num champs à la ligne $row: <br /></p>\n";
                $row++;
                $attr_user[$row - 1] = array();
                for ($c = 0; $c < $num; $c++) {
                    //echo $data[$c] . "<br />\n";
                    $attr_user[$row - 1][$c] = $data[$c];
                }
            }
            fclose($handle);
        }
        //var_dump($attr_user);
        foreach ($attr_user as $value) {
            $firstName = $value[0];
            if (!isset($value[1])) {
                $lastName = null;
            } else {
                $lastName = $value[1];
            }
            if (isset($value[4])) {
                $email = $value[4];
                $user = $em->getRepository('AGILUserBundle:AgilUser')->findBy(array('email' => $email));

                if ($user == null) {
                    $userManager = $this->get('fos_user.user_manager');
                    $user = $userManager->createUser();
                    $lastName = $lastName;
                    $firstName = $firstName;
                    if (strlen($lastName) >= 5 and strlen($firstName) >= 3) {
                        $lastNameTmp = strtolower($lastName);
                        $firstNameTmp = strtolower($firstName);
                        $username = $lastNameTmp[0] . $lastNameTmp[1] . $lastNameTmp[2] .
                            $lastNameTmp[3] . $lastNameTmp[4] . $firstNameTmp[0] . $firstNameTmp[1] . $firstNameTmp[2];
                    } else {
                        $username = strtolower($firstName) . '.' . strtolower($lastName);
                    }
                    $cpt = 0;
                    $usernameTmp = $username;
                    while ($em->getRepository('AGILUserBundle:AgilUser')->findBy(array('username' => $username)) != null) {
                        $username = $usernameTmp;
                        $username .= $cpt;
                        $cpt++;
                    }

                    $password = $this->generate_password();
                    $encoder = $factory->getEncoder($user);
                    $user->setUsername($username);
                    $pass = $encoder->encodePassword($password, $user->getSalt());
                    $user->setUserFirstName($firstName);
                    $user->setUserLastName($lastName);
                    $user->setEmail($email);
                    $user->setPassword($pass);
                    $user->setEnabled(1);

                    $userManager->updateUser($user);
                    $this->loadSkills($user, $em);
                    $nbRegisters++;

                    $url = $request->getSchemeAndHttpHost();
                    $subject = "Amicale GIL[Inscription]";
                    $message = "<p>Bonjour $username,</p>";
                    $message .= "<p>vous avez été invité sur le site <a href=\"$url\" TARGET=\"_blank\">Amicale GIL</a>.</p>";
                    $message .= "<p>Pour vous connecter :</p>";
                    $message .= "<p>Identifiant : $email</p><p>Mot de passe : $password</p>";
                    $message .= "<p>Cordialement</p>";

                    $this->sendMail($subject, $message, $email);
                } else {
                    $this->addFlash('warning', 'L\'utilisateur avec l\'email ' . $email . ' est déjà enregistré.');
                }
            } else {
                $this->addFlash('warning', 'L\'email est vide');
            }
        }

        $this->addFlash('success', $nbRegisters . ' utilisateurs ont été enregistrés.');
    }

    /**
     * mot de passe aleatoire
     * @param $nb_caractere
     * @return string
     */
    function generate_password($nb_caractere = 12)
    {
        $mot_de_passe = "";

        $chaine = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789+@!$%?&";
        $longeur_chaine = strlen($chaine);

        for ($i = 1; $i <= $nb_caractere; $i++) {
            $place_aleatoire = mt_rand(0, ($longeur_chaine - 1));
            $mot_de_passe .= $chaine[$place_aleatoire];
        }

        return $mot_de_passe;
    }

    /**
     * fonction d'envoie de mail
     * @param $subject
     * @param $body
     * @param $to
     */
    function sendMail($subject, $body, $to)
    {
        $headers = 'From: amicale.gil@etu.univ-rouen.fr' . "\r\n";
        $headers .= "Reply-To: amicale.gil@etu.univ-rouen.fr\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"";

        $message = "
        <html>
            <head></head>
            <body>
                $body
            </body>
        </html>";

        if (mail($to, $subject, $message, $headers)) {
        } else {
            $this->addFlash('warning', 'Erreur lors de l\'envois de l\'email.');
        }

    }

    public function loadSkills(AgilUser $user, EntityManager $em)
    {
        $profileSkillsCategoryRepository = $em->getRepository('AGILProfileBundle:AgilProfileSkillsCategory');
        $tagRepository = $em->getRepository('AGILDefaultBundle:AgilTag');
        $skillRepository = $em->getRepository('AGILProfileBundle:AgilSkill');

        foreach ($profileSkillsCategoryRepository->findAll() as $profileSkillsCategory) {
            foreach ($tagRepository->findBy(array("skillCategory" => $profileSkillsCategory)) as $tag) {
                $skill = new AgilSkill($tag, $user);
                $em->persist($skill);
            }
        }
        $em->flush();
    }

}
