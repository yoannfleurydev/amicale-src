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
        $userManager = $this->container->get('fos_user.user_manager');
        $userSuperAdmin = $userManager->createUser();

        $userSuperAdmin->setUsername('superadmin');
        $userSuperAdmin->setEmail('superadmin@amicale.dev');
        $userSuperAdmin->setPlainPassword('superadmin');
        $userSuperAdmin->setEnabled(true);
        $userSuperAdmin->setRoles(array('ROLE_SUPER_ADMIN'));

        $userManager->updateUser($userSuperAdmin, true);

        $this->setReference('superadmin', $userSuperAdmin);
    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder() {
        return 3;
    }
}


