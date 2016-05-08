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
        $superadmin = $this->getReference('superadmin');


        $tags[] = $this->getReference('symfony');
        $tags[] = $this->getReference('angularjs');
        $tags[] = $this->getReference('laravel');
        $tags[] = $this->getReference('jquery');
        $tags[] = $this->getReference('bootstrap');
        $tags[] = $this->getReference('django');
        $tags[] = $this->getReference('spring');
        $tags[] = $this->getReference('nodejs');
        /*
         * Web
         */
        $tags[] = $this->getReference('html');
        $tags[] = $this->getReference('css');
        $tags[] = $this->getReference('php');
        $tags[] = $this->getReference('javascript');
        $tags[] = $this->getReference('jee');
        $tags[] = $this->getReference('xml');
        /*
         * Base de données
         */
        $tags[] = $this->getReference('mysql');
        $tags[] = $this->getReference('postgresql');
        $tags[] = $this->getReference('oracle');
        /*
         * Langages Logiciels
         */
        $tags[] = $this->getReference('java');
        $tags[] = $this->getReference('.net');
        $tags[] = $this->getReference('c');
        $tags[] = $this->getReference('c++');
        $tags[] = $this->getReference('python');
        $tags[] = $this->getReference('vba');
        $tags[] = $this->getReference('ruby');
        /*
         * Gestion de projet
         */
        $tags[] = $this->getReference('git');
        $tags[] = $this->getReference('svn');
        $tags[] = $this->getReference('mercurial');
        $tags[] = $this->getReference('methodes_agiles');
        /*
         * IDE
         */
        $tags[] = $this->getReference('phpstorm');
        $tags[] = $this->getReference('intellij');
        $tags[] = $this->getReference('visual_studio');
        $tags[] = $this->getReference('netbeans');
        $tags[] = $this->getReference('android_studio');
        $tags[] = $this->getReference('pycharm');
        $tags[] = $this->getReference('eclipse');
        /*
         * Mobile
         */
        $tags[] = $this->getReference('android');
        $tags[] = $this->getReference('swift');
        $tags[] = $this->getReference('cordova');

        $skills = array();
        foreach ($tags as $tag) {
            $skills[] = new AgilSkill($tag, $superadmin, 5);
        }

        if (count($skills) > 0) {
            foreach ($skills as $skill) {
                $manager->persist($skill);
            }
            $manager->flush();
        }
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