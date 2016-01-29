<?php

namespace AGIL\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ForumBundle\Entity\AgilForumCategory;

class LoadForumCategoriesData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Cette méthode charge dans la BDD des objets ForumCategory
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categories[] = new AgilForumCategory("Cours Master 1","glyphicon-download","Cette catégorie recense les différents post concernant les cours de la première année du Master");
        $categories[] = new AgilForumCategory("Cours Master 2","glyphicon-download","Cette catégorie recense les différents post concernant les cours de la deuxième année du Master");
        $categories[] = new AgilForumCategory("Tutos & Aide","glyphicon-download","Vous avez besoin d'aide ou vous souhaitez tout simplement poster un tutoriel ? Rendez-vous dans cette catégorie");
        $categories[] = new AgilForumCategory("Informatique","glyphicon-download","Ici, vous pouvez parler de tout et de rien concernant l'informatique");
        $categories[] = new AgilForumCategory("Divers","glyphicon-download","Tout ce qui ne se situe pas dans cette catégorie ce situe dans celle-ci, Divers.");

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
        return 4;
    }
}