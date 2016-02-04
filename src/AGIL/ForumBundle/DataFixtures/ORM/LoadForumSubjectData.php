<?php

namespace AGIL\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ForumBundle\Entity\AgilForumSubject;

class LoadForumSubjectData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Cette méthode charge dans la BDD des objets ForumSubject
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $coursm1Category = $this->getReference('Cours Master 1');
        $coursm2Category = $this->getReference('Cours Master 2');
        $tutosCategory = $this->getReference('Tutos & Aide');
        $infoCategory = $this->getReference('Informatique');
        $diversCategory = $this->getReference('Divers');

        $userSuperAdmin = $this->getReference('superAdmin');

        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"[Aide] Cours de Compilation","Besoin d'aide sur le dernier chapitre du cours");
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-01-25'));
        $this->addReference('subject1', $subjects[count($subjects)-1]);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"DS d'algo du texte","Revision communes ?");
        $this->addReference('subject2', $subjects[count($subjects)-1]);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"Projet LW","Quelques technologies utilisez-vous ?");
        $this->addReference('subject3', $subjects[count($subjects)-1]);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"BDD","Besoin d'aide pour installer Oracle sur ma machine");
        $this->addReference('subject4', $subjects[count($subjects)-1]);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"[Projet] BDD","Quelqu'un a compris les procédures à développer ?");
        $this->addReference('subject5', $subjects[count($subjects)-1]);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"Gestion de Projet","L'utilité des méthodes agiles");
        $this->addReference('subject6', $subjects[count($subjects)-1]);

        $subjects[] = new AgilForumSubject($userSuperAdmin,$tutosCategory,"[Tuto] Git","Bien compris Git et son fonctionnement");
        $this->addReference('subject7', $subjects[count($subjects)-1]);

        $subjects[] = new AgilForumSubject($userSuperAdmin,$infoCategory,"Oculus Rift","Le prix exhorbitant ! Debatons dessus :)");
        $this->addReference('subject8', $subjects[count($subjects)-1]);

        foreach($subjects as $c){
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
        return 6;
    }
}