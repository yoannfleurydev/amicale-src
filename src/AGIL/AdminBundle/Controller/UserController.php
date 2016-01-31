<?php

namespace AGIL\AdminBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use AGIL\UserBundle\Entity\AgilUser;
use AGIL\AdminBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function adminUserAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();
        $qb->select('count(agil_user.id)');
        $qb->from('AGILUserBundle:AgilUser','agil_user');

        $maxUsers = 25;
        $users_count = $qb->getQuery()->getSingleScalarResult();

        $pagination = array(
            'page' => $page,
            'route' => 'agil_admin_user',
            'pages_count' => ceil($users_count / $maxUsers),
            'route_params' => array()
        );

        $users = $em->getRepository('AGILUserBundle:AgilUser')->getListUsers($page, $maxUsers);
        $moderators = $em->getRepository('AGILUserBundle:AgilUser')->findByRole("ROLE_MODERATOR");
        $admins = $em->getRepository('AGILUserBundle:AgilUser')->findByRole("ROLE_ADMIN");

        return $this->render('AGILAdminBundle:User:admin_user.html.twig', array(
            'users' => $users,
            'pagination' => $pagination,
            'moderators' => $moderators,
            'admins' => $admins
        ));
    }

    public function adminUserUpAction($id) {
        $em = $this->getDoctrine()->getManager();

        $user= $em->getRepository('AGILUserBundle:AgilUser')->find($id);

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        } else {
            if ($user->hasRole("ROLE_MODERATOR")) {
                $user->removeRole("ROLE_MODERATOR");
                $user->addRole('ROLE_ADMIN');
            } else {
                $user->addRole("ROLE_MODERATOR");
            }

            $em->persist($user);
            $em->flush();
        }

        return $this->redirect( $this->generateUrl('agil_admin_user') );
    }

    public function adminUserDownAction($id) {
        $em = $this->getDoctrine()->getManager();

        $user= $em->getRepository('AGILUserBundle:AgilUser')->find($id);

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        } else {
            if ($user->hasRole("ROLE_MODERATOR")) {
                $user->removeRole("ROLE_MODERATOR");
            } else {
                $user->removeRole("ROLE_ADMIN");
                $user->addRole("ROLE_MODERATOR");
            }

            $em->persist($user);
            $em->flush();
        }

        return $this->redirect( $this->generateUrl('agil_admin_user') );
    }

    public function adminUserDeleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $user= $em->getRepository('AGILUserBundle:AgilUser')->find($id);

        if (null === $user) {
            throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
        } else {

            $em->remove($user);
            $em->flush();
        }

        return $this->redirect( $this->generateUrl('agil_admin_user') );
    }

    public function adminUserAddAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new UserType(), null);
        $factory = $this->get('security.encoder_factory');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $email = $form->get('email')->getData();
                $user = $em->getRepository('AGILUserBundle:AgilUser')->findBy(array('email' => $email));

                if ($user == null) {
                    $userManager = $this->get('fos_user.user_manager');
                    $user = $userManager->createUser();

                    $password = $this->generate_password();
                    $encoder = $factory->getEncoder($user);
                    $user->setUsername(explode("@", $email)[0]);
                    $pass = $encoder->encodePassword($password, $user->getSalt());
                    $user->setEmail($email);
                    $user->setPassword($pass);
                    $user->setEnabled(1);

                    $userManager->updateUser($user);

                    $subject = "Amicale GIL[Inscription]";
                    $message = 'Bonjour,' . "\r\n" . "Identifiant : " . $email . "\r\n" . "Mot de passe : " . $password;
                    $headers = 'From: amicale.gil@etu.univ-rouen.fr' . "\r\n" .
                        'Reply-To: amicale.gil@etu.univ-rouen.fr' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    mail($email, $subject, $message, $headers);

                    $this->addFlash('notice', 'Invitation envoyée.');
                } else {
                    $this->addFlash('notice', 'Utilisateur déjà enregistré.');
                }
            }
        }
        return $this->render('AGILAdminBundle:User:admin_user_add.html.twig', array(
            'form' => $form->createView()
        ));
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

        for($i = 1; $i <= $nb_caractere; $i++)
        {
            $place_aleatoire = mt_rand(0,($longeur_chaine-1));
            $mot_de_passe .= $chaine[$place_aleatoire];
        }

        return $mot_de_passe;
    }

}
