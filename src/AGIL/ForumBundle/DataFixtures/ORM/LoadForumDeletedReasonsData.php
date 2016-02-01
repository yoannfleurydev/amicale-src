<?php

namespace AGIL\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ForumBundle\Entity\AgilForumDeletedReason;

class LoadForumDeletedReasonsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Cette méthode charge dans la BDD des objets ForumDeletedReason
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $reasons[] = new AgilForumDeletedReason("Bonjour. Nous vous informons qu'un de vos messages sur le forum a été supprimé pour contenu illicite. Veuillez faire attention pour les prochaines fois. Cordialement.");
        $reasons[] = new AgilForumDeletedReason("Bonjour. Nous vous informons qu'un de vos messages sur le forum a été supprimé pour cause de langage vulgaire. Veuillez modérer vos propos les fois prochaines. Cordialement.");

        foreach($reasons as $r){
            $manager->persist($r);
        }
        $manager->flush();
    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }
}