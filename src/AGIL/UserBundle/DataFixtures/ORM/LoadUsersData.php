<?php

namespace AGIL\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsersData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;


    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * Cette méthode charge dans la BDD des objets Users
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        // ############ CREATION D'UN SUPER-ADMINISTRATEUR DE TEST ############
        $userManager = $this->container->get('fos_user.user_manager');
        $userSuperAdmin = $userManager->createUser();
        $userSuperAdmin->setUsername('superAdmin');
        $userSuperAdmin->setEMail('superadmin@amicale.dev');
        $userSuperAdmin->setPlainPassword('superadmin');
        $userSuperAdmin->setEnabled(true);
        $userSuperAdmin->setRoles(array('ROLE_SUPER_ADMIN'));
        $userSuperAdmin->setUserProfilePictureUrl('default.jpg');

        $userManager->updateUser($userSuperAdmin, true);

        $this->setReference('superadmin', $userSuperAdmin);

        // ############ CREATION D'UN ADMINISTRATEUR DE TEST ############
        $userManager = $this->container->get('fos_user.user_manager');
        $userAdmin = $userManager->createUser();
        $userAdmin->setUsername('admin');
        $userAdmin->setEMail('admin@amicale.dev');
        $userAdmin->setPlainPassword('admin');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_ADMIN'));
        $userAdmin->setUserProfilePictureUrl('default.jpg');

        $userManager->updateUser($userAdmin, true);

        $this->setReference('admin', $userAdmin);

        // ############ CREATION D'UN MODERATEUR DE TEST ############
        $userManager = $this->container->get('fos_user.user_manager');
        $userModerator = $userManager->createUser();
        $userModerator->setUsername('moderator');
        $userModerator->setEMail('moderator@amicale.dev');
        $userModerator->setPlainPassword('moderator');
        $userModerator->setEnabled(true);
        $userModerator->setRoles(array('ROLE_MODERATOR'));
        $userModerator->setUserProfilePictureUrl('default.jpg');

        $userManager->updateUser($userModerator, true);

        $this->setReference('moderator', $userModerator);

        // ############ CREATION D'UN MEMBRE DE TEST ############
        $userManager = $this->container->get('fos_user.user_manager');
        $userMember = $userManager->createUser();
        $userMember->setUsername('user');
        $userMember->setEMail('user@amicale.dev');
        $userMember->setPlainPassword('user');
        $userMember->setEnabled(true);
        $userMember->setRoles(array('ROLE_USER'));
        $userMember->setUserProfilePictureUrl('default.jpg');

        $userManager->updateUser($userMember, true);

        $this->setReference('user', $userMember);

        $userManager = $this->container->get('fos_user.user_manager');
        $amicale = $userManager->createUser();
        $amicale->setUsername('amicale');
        $amicale->setEMail('amicale@amicale.dev');
        $amicale->setPlainPassword('amicale');
        $amicale->setEnabled(true);
        $amicale->setRoles(array('ROLE_SUPER_ADMIN'));
        $amicale->setUserProfilePictureUrl('default.jpg');

        $userManager->updateUser($amicale, true);

        $this->setReference('amicale', $amicale);
    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder() {
        return 3;
    }
}


