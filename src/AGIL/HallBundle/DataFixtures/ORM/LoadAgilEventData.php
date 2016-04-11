<?php

namespace AGIL\HallBundle\DataFixtures\ORM;

use AGIL\HallBundle\Entity\AgilEvent;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ForumBundle\Entity\AgilForumAnswer;
use Symfony\Component\Validator\Constraints\DateTime;

class LoadAgilEventData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * Cette méthode charge dans la BDD des objets Event
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // On récupère les objets Fixture : User
        $amicale = $this->getReference('amicale');
        $superadmin = $this->getReference('superadmin');

        $event = new AgilEvent();
        $event->setEventTitle('Codeurs En Seine');
        $event->setEventText("Codeurs en Seine est un événement qui permet d'assister à des conférences sur le Java,
        le Web, les méthodes Agiles, ainsi que les dernières technologies du moment.
        https://www.youtube.com/watch?v=YOlKxTxqsGQ La vidéo ci-dessus présente CES 2015");
        $event->setEventDate(new \DateTime('2016-02-14 08:00:00'));
        $event->setEventDateEnd(new \DateTime('2016-02-15 18:00:00'));
        $event->setEventPostDate(new \DateTime());
        $event->setUser($amicale);

        $events[] = $event;

        $event = new AgilEvent();
        $event->setEventTitle('Remise des diplômes');
        $event->setEventText("La remise des diplômes à lieu tout les ans à la même date. Vous pourrez venir chercher
        vos passeport pour le monde professionnel ce 14 juin à l'Université où un pot sera présent.");
        $event->setEventDate(new \DateTime('2016-06-14 12:00:00'));
        $event->setEventDateEnd(new \DateTime('2016-06-14 16:00:00'));
        $event->setEventPostDate(new \DateTime());
        $event->setUser($superadmin);
        $events[] = $event;

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
        return 9;
    }
}