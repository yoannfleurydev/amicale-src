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
        $userMember = $this->getReference('userMember');

        $tagPHP = $this->getReference('tagPHP');
        $tagJava = $this->getReference('tagJava');
        $tagAndroid = $this->getReference('tagAndroid');
        $tagJEE = $this->getReference('tagJEE');

        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"[Aide] Cours de Compilation","Besoin d'aide sur le dernier chapitre du cours");
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-02-02 11:11:11'));
        $subjects[count($subjects)-1]->addTag($tagPHP);
        $subjects[count($subjects)-1]->addTag($tagJava);
        $subjects[count($subjects)-1]->addTag($tagJEE);
        $this->addReference('subject1', $subjects[count($subjects)-1]);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"DS d'algo du texte","Revision communes ?",true);
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-02-01 01:23:12'));
        $subjects[count($subjects)-1]->addTag($tagJEE);
        $this->addReference('subject2', $subjects[count($subjects)-1]);
        $subjects[count($subjects)-1]->addTag($tagAndroid);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"Projet LW","Quelques technologies utilisez-vous ?");
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-02-01 09:13:31'));
        $this->addReference('subject3', $subjects[count($subjects)-1]);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"BDD","Besoin d'aide pour installer Oracle sur ma machine");
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-02-03 09:11:41'));
        $this->addReference('subject4', $subjects[count($subjects)-1]);
        $subjects[count($subjects)-1]->addTag($tagJEE);
        $subjects[count($subjects)-1]->addTag($tagJava);
        $subjects[] = new AgilForumSubject($userMember,$coursm1Category,"[Projet] BDD","Quelqu'un a compris les procédures à développer ?");
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-02-03 09:11:41'));
        $subjects[count($subjects)-1]->addTag($tagJEE);
        $subjects[count($subjects)-1]->addTag($tagPHP);
        $subjects[count($subjects)-1]->addTag($tagAndroid);
        $subjects[count($subjects)-1]->addTag($tagJava);
        $this->addReference('subject5', $subjects[count($subjects)-1]);
        $subjects[] = new AgilForumSubject($userSuperAdmin,$coursm1Category,"Gestion de Projet","L'utilité des méthodes agiles");
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-02-02 01:42:44'));
        $this->addReference('subject6', $subjects[count($subjects)-1]);

        $subjects[] = new AgilForumSubject($userSuperAdmin,$tutosCategory,"[Tuto] Git","Bien compris Git et son fonctionnement");
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-02-01 01:42:44'));
        $this->addReference('subject7', $subjects[count($subjects)-1]);

        $subjects[] = new AgilForumSubject($userSuperAdmin,$infoCategory,"Oculus Rift","Le prix exhorbitant ! Debatons dessus :)");
        $subjects[count($subjects)-1]->setForumSubjectPostDate(new \DateTime('2016-02-02 04:12:44'));
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