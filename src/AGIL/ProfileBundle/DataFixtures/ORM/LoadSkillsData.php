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
        $users[] = $this->getReference('superadmin');
        $users[] = $this->getReference('user');
        $users[] = $this->getReference('moderator');
        $users[] = $this->getReference('amicale');

        $tags[] = $this->getReference('tagPHP');
        $tags[] = $this->getReference('tagJava');
        $tags[] = $this->getReference('tagAndroid');
        $tags[] = $this->getReference('tagJEE');
        $tags[] = $this->getReference('tagCSS');
        $tags[] = $this->getReference('tagC++');
        $tags[] = $this->getReference('tagJavascript');
        $tags[] = $this->getReference('tagHTML');
        $tags[] = $this->getReference('tagC');
        $tags[] = $this->getReference('tagOCaml');
        $tags[] = $this->getReference('tagPL/SQL');
        $tags[] = $this->getReference('tagSQL');
        $tags[] = $this->getReference('tagCordova');
        $tags[] = $this->getReference('tagObjectiveC');
        $tags[] = $this->getReference('tagSwift');


        foreach($users as $user) {
            foreach ($tags as $tag) {
                $skills[] = new AgilSkill($tag, $user, 5);
            }
        }

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