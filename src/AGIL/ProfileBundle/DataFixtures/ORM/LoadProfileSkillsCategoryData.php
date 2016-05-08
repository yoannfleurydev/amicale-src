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
        $categories[] = new AgilProfileSkillsCategory('Framework et bibliothèques');
        $this->addReference('Framework et bibliothèques', $categories[count($categories)-1]);

        $categories[] = new AgilProfileSkillsCategory("Langages Web");
        $this->addReference('Langages Web', $categories[count($categories)-1]);

        $categories[] = new AgilProfileSkillsCategory("Langages Logiciels");
        $this->addReference('Langages Logiciels', $categories[count($categories)-1]);

        $categories[] = new AgilProfileSkillsCategory("Base De Données");
        $this->addReference('Base De Données', $categories[count($categories)-1]);

        $categories[] = new AgilProfileSkillsCategory("Mobile");
        $this->addReference('Mobile', $categories[count($categories)-1]);

        $categories[] = new AgilProfileSkillsCategory('Gestion de projet');
        $this->addReference('Gestion de projet', $categories[count($categories)-1]);

        $categories[] = new AgilProfileSkillsCategory('IDE');
        $this->addReference('IDE', $categories[count($categories)-1]);


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