<?php

namespace AGIL\HallBundle\DataFixtures\ORM;

use AGIL\HallBundle\Entity\AgilEvent;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ForumBundle\Entity\AgilForumAnswer;

class LoadAgilEventData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Cette méthode charge dans la BDD des objets ForumAnswer
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userSuperAdmin = $this->getReference('superadmin');
        $eventTitle     = "Chasse aux bugs sur Amicale GIL ";
        $eventPostDate  = new \DateTime('2016-02-02 11:11:11');
        $eventDate      = new \DateTime('2016-02-02 11:11:11');
        $eventDateEnd   = $eventPostDate;
        $eventText      = " Journée banalisé pour approcher les bugs du sites Amicale GIL ....";



        $events[] = new AgilEvent($userSuperAdmin, $eventTitle, $eventPostDate,$eventDate , $eventDateEnd, $eventText);
        $events[] = new AgilEvent($userSuperAdmin, $eventTitle, $eventPostDate,$eventDate , $eventDateEnd, $eventText);
        $events[] = new AgilEvent($userSuperAdmin, $eventTitle, $eventPostDate,$eventDate , $eventDateEnd, $eventText);
        $events[] = new AgilEvent($userSuperAdmin, $eventTitle, $eventPostDate,$eventDate , $eventDateEnd, $eventText);

        foreach($events as $event){
            $manager->persist($event);
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