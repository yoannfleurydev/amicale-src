<?php

namespace AGIL\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ForumBundle\Entity\AgilForumAnswer;

class LoadForumAnswerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Cette méthode charge dans la BDD des objets ForumAnswer
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // On récupère les objets Fixture : Subject
        $subject1 = $this->getReference('subject1');
        $subject2 = $this->getReference('subject2');
        $subject3 = $this->getReference('subject3');
        $subject4 = $this->getReference('subject4');
        $subject5 = $this->getReference('subject5');
        $subject6 = $this->getReference('subject6');
        $subject7 = $this->getReference('subject7');
        $subject8 = $this->getReference('subject8');

        $userSuperAdmin = $this->getReference('superadmin');
        $userMember = $this->getReference('user');

        $answers[] = new AgilForumAnswer($subject2,$userSuperAdmin,"Bonjour. Je propose de se faire une session de cours
         de révision pour le 3 Février. Est ce que cela tente des gens ? Que souhaitez-vous réviser en priorité ?");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-01 01:23:12'));

        $answers[] = new AgilForumAnswer($subject2,$userMember,"Moi ça m'intéresse ! J'ai rien compris aux Bon-Suff et Dern-Occ ...");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-02 11:12:01'));

        $answers[] = new AgilForumAnswer($subject2,$userSuperAdmin,"Super ! Quand sera tu dispo ?");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-02 11:15:45'));

        $answers[] = new AgilForumAnswer($subject2,$userMember,"La semaine prochaine, en fonction de mon emploi du temps ou pourrait faire ça");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-02 12:35:45'));

        $answers[] = new AgilForumAnswer($subject2,$userSuperAdmin,"Okay, je vais poster un message sur Facebook ");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-02 13:00:12'));

        $answers[] = new AgilForumAnswer($subject1,$userSuperAdmin,"Quelqu'un pige le cours de Compilation ?");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-02 11:11:11'));

        $answers[] = new AgilForumAnswer($subject3,$userSuperAdmin,"Je souhaiterai savoir quelles technos utilisez-vous pour le projet de LW1 ?");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-01 09:13:31'));

        $answers[] = new AgilForumAnswer($subject4,$userSuperAdmin,"Quelqu'un sait comment installer Oracle sur Windows ?");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-03 09:11:41'));

        $answers[] = new AgilForumAnswer($subject5,$userMember,"Je ne comprend pas ce que signifie la dernière procédure à faire pour le projet de BDD ?");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-03 09:11:41'));

        $answers[] = new AgilForumAnswer($subject6,$userSuperAdmin,"Quelqu'un a pigé les méthodes agiles ?");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-02 01:42:44'));

        $answers[] = new AgilForumAnswer($subject7,$userSuperAdmin,"Comment fonctionne le checkout ?");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-01 01:42:44'));

        $answers[] = new AgilForumAnswer($subject8,$userSuperAdmin,"Avez vous vu le prix de l'Oculus en Europe ? 700€ !!!!!");
        $answers[count($answers)-1]->setForumAnswerPostDate(new \DateTime('2016-02-02 04:12:44'));

        foreach($answers as $a){
            $manager->persist($a);
        }
        $manager->flush();

    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder()
    {
        return 7;
    }
}