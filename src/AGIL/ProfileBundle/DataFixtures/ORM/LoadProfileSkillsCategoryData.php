<?php

namespace AGIL\ProfileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ProfileBundle\Entity\AgilProfileSkillsCategory;

class LoadProfileSkillsCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Cette méthode charge dans la BDD des objets ProfileSkillsCategory
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categories[] = new AgilProfileSkillsCategory("Web");
        $this->addReference('Web', $categories[count($categories)-1]);
        $categories[] = new AgilProfileSkillsCategory("Logiciel");
        $this->addReference('Logiciel', $categories[count($categories)-1]);
        $categories[] = new AgilProfileSkillsCategory("BDD");
        $this->addReference('BDD', $categories[count($categories)-1]);
        $categories[] = new AgilProfileSkillsCategory("Mobile");
        $this->addReference('Mobile', $categories[count($categories)-1]);

        foreach($categories as $c){
            $manager->persist($c);
        }
        $manager->flush();
    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}