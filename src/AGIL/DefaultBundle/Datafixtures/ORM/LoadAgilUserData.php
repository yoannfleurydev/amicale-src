<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\DefaultBundle\Entity\AgilUser;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $agilUser = new AgilUser();

        // Création d'un utilisateur
        $agilUser->setRoles(array('ROLE_USER'));
        $agilUser->setFirstName('MyfirstName');
        $agilUser->setLastName('MylastName');
        $agilUser->setUsername('MyUserName');
        $agilUser->setEmail('example@email.com');
        $agilUser->setCvUrl('mywebsite.com/cv.pdf');
        $agilUser->setProfilePictureUrl('mywebsite.com/pic.jpg');

        $manager->persist();
        $manager->flush();
    }
}