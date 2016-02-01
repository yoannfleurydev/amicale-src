<?php

namespace AGIL\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AGIL\UserBundle\Entity\AgilUser;

class LoadUsersData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;


    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Cette méthode charge dans la BDD des objets Users
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        /* Quentin -> A COMPLETER QUAND FOSUSERBUNDLE SERA CORRECTEMENT IMPORTE ET LA PARTIE UTILISATEUR TERMINEE
        */

        // ############ CREATION D'UN SUPER-ADMINISTRATEUR DE TEST ############
        $userSuperAdmin = new AgilUser();
        $userSuperAdmin->setRoles(array('ROLE_SUPER_ADMIN'));
        $userSuperAdmin->setUsername('superAdmin');
        $userSuperAdmin->setEMail('superadmin@superadmin.fr');

        // Encodage du mot de passe
        //$encoder = $this->container->get('security.password_encoder');
        //$encoded = $encoder->encodePassword($userSuperAdmin, 'superAdmin');
        //$userSuperAdmin->setPassword($encoded);
        $userSuperAdmin->setPassword('superAdmin');

        $userLists[] = $userSuperAdmin;
        $this->addReference('superAdmin', $userLists[count($userLists)-1]);

        foreach($userLists as $users){
            $manager->persist($users);
        }
        $manager->flush();


    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}


