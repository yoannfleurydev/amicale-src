<?php

namespace AGIL\ProfileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\DefaultBundle\Entity\AgilMailingList;

/**
 * Class LoadMailingListData
 *
 * @package \AGIL\ProfileBundle\DataFixtures\ORM
 */
class LoadMailingListData implements FixtureInterface
{
    public function load(ObjectManager $manager) {
        $names = array(
            'Annonces',
            'Evenements',
            'Forum'
        );

        foreach ($names as $name) {
            $mailingList = new AgilMailingList();
            $mailingList->setMailingListName($name);
            $manager->persist($mailingList);
        }

        $manager->flush();
    }
}