<?php

namespace AGIL\ProfileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ProfileBundle\Entity\AgilSkill;

class LoadSkillsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Cette méthode charge dans la BDD des objets Skills
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // On récupère les objets Fixture : User et Tags
        $userSuperAdmin = $this->getReference('superAdmin');
        $userMember = $this->getReference('userMember');

        $tagPHP = $this->getReference('tagPHP');
        $tagJava = $this->getReference('tagJava');
        $tagAndroid = $this->getReference('tagAndroid');
        $tagJEE = $this->getReference('tagJEE');


        $skills[] = new AgilSkill($tagPHP,$userSuperAdmin,5);
        $skills[] = new AgilSkill($tagAndroid,$userSuperAdmin,8);
        $skills[] = new AgilSkill($tagJava,$userSuperAdmin,7);
        $skills[] = new AgilSkill($tagJEE,$userSuperAdmin,8);


        foreach($skills as $s){
            $manager->persist($s);
        }
        $manager->flush();

    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder()
    {
        return 8;
    }
}