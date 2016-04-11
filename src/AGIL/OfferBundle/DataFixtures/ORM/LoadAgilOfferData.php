<?php

namespace AGIL\OfferBundle\DataFixtures\ORM;

use AGIL\DefaultBundle\Entity\AgilTag;
use AGIL\OfferBundle\Entity\AgilOffer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\ForumBundle\Entity\AgilForumAnswer;
use Symfony\Component\Validator\Constraints\DateTime;

class LoadAgilOfferData extends AbstractFixture implements OrderedFixtureInterface {
    /**
     * Cette méthode charge dans la BDD des objets Event
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $offer = new AgilOffer();
        $offer->setOfferTitle('Développeur Web Frontend');
        $offer->setOfferText("
            <p>Nous accueillons un développeur frontend maitrisant les technologies suivantes :</p>
            <ul>
                <li>jQuery/Javascript</li>
                <li>Bootstrap</li>
                <li>SASS</li>
                <li>HTML5</li>
                <li>CSS3</li>
            </ul>
            <p>Vous ferez parti d'une équipe dédiée à un ou deux projets, et travaillerez en relative autonomie.
            Il est nécessaire d'avoir un bon niveau dans au moins quatre des cinq domaines listés ci-dessus, car les projets démarrent rapidement.</p>
        ");
        $offer->setOfferType("emploi");
        $offer->setOfferAuthor("Matmut");
        $offer->setOfferPostDate(new \DateTime());
        $offer->setOfferEmail("amicale@amicale.dev");
        $date = new \DateTime();
        $offer->setOfferExpirationDate($date->add(new \DateInterval("P3M")));
        $offer->setOfferPublish(true);
        $offers[] = $offer;

        $offer = new AgilOffer();
        $offer->setOfferTitle('Développeur Web Backend');
        $offer->setOfferText("
            <p>Nous accueillons un développeur backend maitrisant les technologies suivantes :</p>
            <ul>
                <li>PHP</li>
                <li>JavaScript/JQuery</li>
                <li>Framework Symfony</li>
                <li>HTML5</li>
            </ul>
            <p>Vous ferez parti d'une équipe dédiée à un ou deux projets, et travaillerez en relative autonomie.</p>
        ");
        $offer->setOfferType("stage");
        $offer->setOfferAuthor("LcL");
        $offer->setOfferPostDate(new \DateTime());
        $offer->setOfferEmail("john.smith@amicale.dev");
        $date = new \DateTime();
        $offer->setOfferExpirationDate($date->add(new \DateInterval("P1M")));
        $offer->setOfferPublish(true);
        $offers[] = $offer;

        $offer = new AgilOffer();
        $offer->setOfferTitle('Développeur Web Fullstack');
        $offer->setOfferText("
            <p>Nous accueillons un développeur fullstack maitrisant les technologies suivantes :</p>
            <ul>
                <li>PHP</li>
                <li>JavaScript/JQuery</li>
                <li>Framework Symfony</li>
                <li>HTML5</li>
                <li>CSS3</li>
                <li>Bootstrap</li>
                <li>HTML5</li>
                <li>Linux et shell scripting</li>
            </ul>
            <p>Vous ferez parti d'une équipe dédiée à un ou deux projets, et travaillerez en relative autonomie.</p>
        ");
        $offer->setOfferType("stage");
        $offer->setOfferAuthor("Google");
        $offer->setOfferPostDate(new \DateTime());
        $offer->setOfferEmail("amicale@amicale.dev");
        $date = new \DateTime();
        $offer->setOfferExpirationDate($date->add(new \DateInterval("P6M")));
        $offer->setOfferPublish(false);
        $offers[] = $offer;


        foreach($offers as $offer){
            $manager->persist($offer);
        }
        $manager->flush();

    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder()
    {
        return 10;
    }
}