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
        $userSuperAdmin->setEMail('superadmin@superadmin.fr');
        $userSuperAdmin->setPlainPassword('superAdmin');
        $userSuperAdmin->setEnabled(true);
        $userSuperAdmin->setRoles(array('ROLE_SUPER_ADMIN'));

        $userManager->updateUser($userSuperAdmin, true);

        $this->setReference('superAdmin', $userSuperAdmin);

        // ############ CREATION D'UN MEMBRE DE TEST ############
        $userManager = $this->container->get('fos_user.user_manager');
        $userMember = $userManager->createUser();
        $userMember->setUsername('user');
        $userMember->setEMail('user@user.fr');
        $userMember->setPlainPassword('user');
        $userMember->setEnabled(true);
        $userMember->setRoles(array('ROLE_USER'));

        $userManager->updateUser($userMember, true);

        $this->setReference('userMember', $userMember);

        $userManager = $this->container->get('fos_user.user_manager');
        $userSuperAdmin = $userManager->createUser();
        $userSuperAdmin->setUsername('amicale');
        $userSuperAdmin->setEMail('amicale@amicale.dev');
        $userSuperAdmin->setPlainPassword('amicale');
        $userSuperAdmin->setEnabled(true);
        $userSuperAdmin->setRoles(array('ROLE_SUPER_ADMIN'));

        $userManager->updateUser($userSuperAdmin, true);

        $this->setReference('superAdmin', $userSuperAdmin);
    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder() {
        return 3;
    }
}


