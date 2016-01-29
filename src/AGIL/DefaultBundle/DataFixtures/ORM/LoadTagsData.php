<?php

namespace AGIL\DefaultBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AGIL\DefaultBundle\Entity\AgilTag;

class LoadTagsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Cette méthode charge dans la BDD des objets Tags
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Récupération des 4 objets de ProfileSkillsCategory de la Fixture 1
        $webCategory = $this->getReference('Web');
        $logicielCategory = $this->getReference('Logiciel');
        $BDDCategory = $this->getReference('BDD');
        $mobileCategory = $this->getReference('Mobile');


        $tags[] = new AgilTag("PHP","tag-purpleLight",$webCategory);
        $tags[] = new AgilTag("Java","tag-redDark",$logicielCategory);
        $tags[] = new AgilTag("CSS","tag-greenDark",$webCategory);
        $tags[] = new AgilTag("Android","tag-greenLight",$mobileCategory);
        $tags[] = new AgilTag("C++","tag-blueDark",$logicielCategory);
        $tags[] = new AgilTag("JavaScript","tag-yellow",$webCategory);
        $tags[] = new AgilTag("HTML","tag-orangeDark",$webCategory);
        $tags[] = new AgilTag("C","tag-black",$logicielCategory);

        $tags[] = new AgilTag("OCaml","tag-orangeLight",$logicielCategory);
        $tags[] = new AgilTag("JEE","tag-blueLight",$webCategory);
        $tags[] = new AgilTag("PL/SQL","tag-redLight",$BDDCategory);
        $tags[] = new AgilTag("SQL","tag-purpleDark",$BDDCategory);
        $tags[] = new AgilTag("Cordova ","tag-greyDark",$mobileCategory);
        $tags[] = new AgilTag("ObjectiveC","tag-greyLight",$mobileCategory);
        $tags[] = new AgilTag("Swift","tag-cyan",$mobileCategory);
        $tags[] = new AgilTag("C#","tag-default",NULL);
        $tags[] = new AgilTag("Oracle","tag-default",NULL);
        $tags[] = new AgilTag("MySQL","tag-default",NULL);
        $tags[] = new AgilTag("Wamp","tag-default",NULL);
        $tags[] = new AgilTag("Mamp","tag-default",NULL);
        $tags[] = new AgilTag("Lamp","tag-default",NULL);
        $tags[] = new AgilTag("PHPMyAdmin","tag-default",NULL);
        $tags[] = new AgilTag("XML","tag-default",NULL);
        $tags[] = new AgilTag("XSL","tag-default",NULL);
        $tags[] = new AgilTag("XSD","tag-default",NULL);
        $tags[] = new AgilTag("UML","tag-default",NULL);
        $tags[] = new AgilTag("Symfony","tag-default",NULL);
        $tags[] = new AgilTag("CakePHP","tag-default",NULL);
        $tags[] = new AgilTag("Laravel","tag-default",NULL);
        $tags[] = new AgilTag("Silex","tag-default",NULL);
        $tags[] = new AgilTag("Wordpress","tag-default",NULL);
        $tags[] = new AgilTag("VBA","tag-default",NULL);
        $tags[] = new AgilTag("Python","tag-default",NULL);
        $tags[] = new AgilTag("Shell","tag-default",NULL);
        $tags[] = new AgilTag("Lisp","tag-default",NULL);
        $tags[] = new AgilTag("Git","tag-default",NULL);
        $tags[] = new AgilTag("LUA","tag-default",NULL);
        $tags[] = new AgilTag("Perl","tag-default",NULL);
        $tags[] = new AgilTag("Pascal","tag-default",NULL);
        $tags[] = new AgilTag("AngularJS","tag-default",NULL);
        $tags[] = new AgilTag("NodeJS","tag-default",NULL);
        $tags[] = new AgilTag("Nginx","tag-default",NULL);
        $tags[] = new AgilTag("Apache","tag-default",NULL);
        $tags[] = new AgilTag("Web","tag-default",NULL);
        $tags[] = new AgilTag("Logiciel","tag-default",NULL);
        $tags[] = new AgilTag("Photoshop","tag-default",NULL);
        $tags[] = new AgilTag("PHPStorm","tag-default",NULL);
        $tags[] = new AgilTag("Lightroom","tag-default",NULL);
        $tags[] = new AgilTag("FinalCutPro","tag-default",NULL);
        $tags[] = new AgilTag("SonyVegas","tag-default",NULL);
        $tags[] = new AgilTag("LogicPro","tag-default",NULL);
        $tags[] = new AgilTag("iWorks","tag-default",NULL);
        $tags[] = new AgilTag("OpenOffice","tag-default",NULL);
        $tags[] = new AgilTag("LibreOffice","tag-default",NULL);
        $tags[] = new AgilTag("LaTeX","tag-default",NULL);
        $tags[] = new AgilTag("Cobol","tag-default",NULL);
        $tags[] = new AgilTag("Reseau","tag-default",NULL);
        $tags[] = new AgilTag("Fortran","tag-default",NULL);
        $tags[] = new AgilTag("Eclipse","tag-default",NULL);
        $tags[] = new AgilTag("IntelliJ","tag-default",NULL);
        $tags[] = new AgilTag("JSP","tag-default",NULL);
        $tags[] = new AgilTag("Ruby","tag-default",NULL);
        $tags[] = new AgilTag("Scala","tag-default",NULL);
        $tags[] = new AgilTag("Unix","tag-default",NULL);
        $tags[] = new AgilTag("Linux","tag-default",NULL);
        $tags[] = new AgilTag("Windows","tag-default",NULL);
        $tags[] = new AgilTag("Mac","tag-default",NULL);
        $tags[] = new AgilTag("Vagrant","tag-default",NULL);
        $tags[] = new AgilTag("VM","tag-default",NULL);
        $tags[] = new AgilTag("Yacc","tag-default",NULL);
        $tags[] = new AgilTag("Flex","tag-default",NULL);
        $tags[] = new AgilTag("Bison","tag-default",NULL);
        $tags[] = new AgilTag("jQuery ","tag-default",NULL);
        $tags[] = new AgilTag("Projet","tag-default",NULL);
        $tags[] = new AgilTag("Bootstrap","tag-default",NULL);
        $tags[] = new AgilTag("Materialize","tag-default",NULL);
        $tags[] = new AgilTag("Foundation","tag-default",NULL);
        $tags[] = new AgilTag("Twitter","tag-default",NULL);
        $tags[] = new AgilTag("Facebook","tag-default",NULL);
        $tags[] = new AgilTag("Youtube","tag-default",NULL);
        $tags[] = new AgilTag("SublimeText","tag-default",NULL);
        $tags[] = new AgilTag("Atom","tag-default",NULL);
        $tags[] = new AgilTag("NotePad","tag-default",NULL);
        $tags[] = new AgilTag("MozillaFirefox","tag-default",NULL);
        $tags[] = new AgilTag("InternetExplorer","tag-default",NULL);
        $tags[] = new AgilTag("Edge","tag-default",NULL);
        $tags[] = new AgilTag("GoogleChrome","tag-default",NULL);
        $tags[] = new AgilTag("Safari","tag-default",NULL);
        $tags[] = new AgilTag("Google","tag-default",NULL);
        $tags[] = new AgilTag("iOs","tag-default",NULL);
        $tags[] = new AgilTag("Gmail","tag-default",NULL);
        $tags[] = new AgilTag("Dropbox","tag-default",NULL);
        $tags[] = new AgilTag("Github","tag-default",NULL);
        $tags[] = new AgilTag("GoogleDrive","tag-default",NULL);
        $tags[] = new AgilTag("SourceTree","tag-default",NULL);
        $tags[] = new AgilTag("IDE","tag-default",NULL);
        $tags[] = new AgilTag("VisualStudio","tag-default",NULL);
        $tags[] = new AgilTag("Test","tag-default",NULL);
        $tags[] = new AgilTag("Debug","tag-default",NULL);
        $tags[] = new AgilTag("Bug","tag-default",NULL);
        $tags[] = new AgilTag("HelpMe","tag-default",NULL);
        $tags[] = new AgilTag("Stage","tag-default",NULL);
        $tags[] = new AgilTag("Emploi","tag-default",NULL);
        $tags[] = new AgilTag("CDI","tag-default",NULL);
        $tags[] = new AgilTag("CDD","tag-default",NULL);
        $tags[] = new AgilTag("Entreprise","tag-default",NULL);
        $tags[] = new AgilTag("Informatique","tag-default",NULL);
        $tags[] = new AgilTag("Universite","tag-default",NULL);
        $tags[] = new AgilTag("Rouen","tag-default",NULL);
        $tags[] = new AgilTag("FirefoxOS","tag-default",NULL);
        $tags[] = new AgilTag("Debian","tag-default",NULL);
        $tags[] = new AgilTag("Ubuntu","tag-default",NULL);
        $tags[] = new AgilTag("WindowsXP","tag-default",NULL);
        $tags[] = new AgilTag("WindowsVista","tag-default",NULL);
        $tags[] = new AgilTag("Windows7","tag-default",NULL);
        $tags[] = new AgilTag("Windows8","tag-default",NULL);
        $tags[] = new AgilTag("Windows10","tag-default",NULL);
        $tags[] = new AgilTag("XUbuntu","tag-default",NULL);
        $tags[] = new AgilTag("Paint","tag-default",NULL);
        $tags[] = new AgilTag("Gimp","tag-default",NULL);
        $tags[] = new AgilTag("ControleContinu","tag-default",NULL);
        $tags[] = new AgilTag("ReactJS","tag-default",NULL);
        $tags[] = new AgilTag("Grunt","tag-default",NULL);
        $tags[] = new AgilTag("Gump","tag-default",NULL);
        $tags[] = new AgilTag("RaspberryPI","tag-default",NULL);
        $tags[] = new AgilTag("Raspberry","tag-default",NULL);
        $tags[] = new AgilTag("Bit","tag-default",NULL);
        $tags[] = new AgilTag("Byte","tag-default",NULL);
        $tags[] = new AgilTag("SGBD","tag-default",NULL);
        $tags[] = new AgilTag("JSON","tag-default",NULL);
        $tags[] = new AgilTag("Securite","tag-default",NULL);
        $tags[] = new AgilTag("Model","tag-default",NULL);
        $tags[] = new AgilTag("View","tag-default",NULL);
        $tags[] = new AgilTag("Controller","tag-default",NULL);
        $tags[] = new AgilTag("MVC","tag-default",NULL);
        $tags[] = new AgilTag("Protocole","tag-default",NULL);
        $tags[] = new AgilTag("MVP","tag-default",NULL);
        $tags[] = new AgilTag("Presenter","tag-default",NULL);
        $tags[] = new AgilTag("Docker","tag-default",NULL);
        $tags[] = new AgilTag("Tutoriel","tag-default",NULL);
        $tags[] = new AgilTag("Systeme","tag-default",NULL);
        $tags[] = new AgilTag("Developpeur","tag-default",NULL);
        $tags[] = new AgilTag("Programmeur","tag-default",NULL);
        $tags[] = new AgilTag("ASUS","tag-default",NULL);
        $tags[] = new AgilTag("HP","tag-default",NULL);
        $tags[] = new AgilTag("Ordinateur","tag-default",NULL);
        $tags[] = new AgilTag("Samsung","tag-default",NULL);
        $tags[] = new AgilTag("Dell","tag-default",NULL);
        $tags[] = new AgilTag("Toshiba ","tag-default",NULL);
        $tags[] = new AgilTag("Application","tag-default",NULL);
        $tags[] = new AgilTag("Site","tag-default",NULL);
        $tags[] = new AgilTag("Internet","tag-default",NULL);
        $tags[] = new AgilTag("WWW","tag-default",NULL);
        $tags[] = new AgilTag("CM","tag-default",NULL);
        $tags[] = new AgilTag("TD","tag-default",NULL);
        $tags[] = new AgilTag("TP","tag-default",NULL);
        $tags[] = new AgilTag("CC","tag-default",NULL);
        $tags[] = new AgilTag("Examen","tag-default",NULL);
        $tags[] = new AgilTag("Faille","tag-default",NULL);
        $tags[] = new AgilTag("Code","tag-default",NULL);
        $tags[] = new AgilTag("PseudoCode","tag-default",NULL);
        $tags[] = new AgilTag("W3C","tag-default",NULL);
        $tags[] = new AgilTag("DTD","tag-default",NULL);
        $tags[] = new AgilTag("Codage","tag-default",NULL);
        $tags[] = new AgilTag("Agile","tag-default",NULL);
        $tags[] = new AgilTag("Scrum","tag-default",NULL);
        $tags[] = new AgilTag("XP","tag-default",NULL);
        $tags[] = new AgilTag("Planning","tag-default",NULL);
        $tags[] = new AgilTag("Opera","tag-default",NULL);
        $tags[] = new AgilTag("Acer","tag-default",NULL);
        $tags[] = new AgilTag("BitBucket","tag-default",NULL);
        $tags[] = new AgilTag("BiBTeX","tag-default",NULL);
        $tags[] = new AgilTag("Markdown","tag-default",NULL);
        $tags[] = new AgilTag("Jade","tag-default",NULL);
        $tags[] = new AgilTag("Twig","tag-default",NULL);
        $tags[] = new AgilTag("Doctrine","tag-default",NULL);
        $tags[] = new AgilTag("Composer","tag-default",NULL);
        $tags[] = new AgilTag("ORM","tag-default",NULL);
        $tags[] = new AgilTag("NPM","tag-default",NULL);
        $tags[] = new AgilTag("TOR","tag-default",NULL);
        $tags[] = new AgilTag("API","tag-default",NULL);
        $tags[] = new AgilTag("Bower","tag-default",NULL);
        $tags[] = new AgilTag("Package","tag-default",NULL);
        $tags[] = new AgilTag("Django","tag-default",NULL);
        $tags[] = new AgilTag("Drupal","tag-default",NULL);
        $tags[] = new AgilTag("Joomla","tag-default",NULL);
        $tags[] = new AgilTag("Hebergeur","tag-default",NULL);
        $tags[] = new AgilTag("Serveur","tag-default",NULL);
        $tags[] = new AgilTag("OVH","tag-default",NULL);
        $tags[] = new AgilTag("Bash","tag-default",NULL);
        $tags[] = new AgilTag("Technologie","tag-default",NULL);
        $tags[] = new AgilTag("Blog","tag-default",NULL);
        $tags[] = new AgilTag("Siri","tag-default",NULL);
        $tags[] = new AgilTag("Ionic","tag-default",NULL);
        $tags[] = new AgilTag("Culture","tag-default",NULL);
        $tags[] = new AgilTag("Cortana","tag-default",NULL);
        $tags[] = new AgilTag("ENT","tag-default",NULL);
        $tags[] = new AgilTag("Email","tag-default",NULL);
        $tags[] = new AgilTag("Mobile","tag-default",NULL);
        $tags[] = new AgilTag("Tablette","tag-default",NULL);
        $tags[] = new AgilTag("FrontEnd","tag-default",NULL);
        $tags[] = new AgilTag("BackEnd","tag-default",NULL);
        $tags[] = new AgilTag("Fullstack","tag-default",NULL);
        $tags[] = new AgilTag("Proxy","tag-default",NULL);
        $tags[] = new AgilTag("CDR","tag-default",NULL);
        $tags[] = new AgilTag("STB","tag-default",NULL);
        $tags[] = new AgilTag("DAL","tag-default",NULL);
        $tags[] = new AgilTag("PDD","tag-default",NULL);
        $tags[] = new AgilTag("ADR","tag-default",NULL);
        $tags[] = new AgilTag("Documentation","tag-default",NULL);
        $tags[] = new AgilTag("CodeursEnSeine","tag-default",NULL);
        $tags[] = new AgilTag("SASS","tag-default",NULL);
        $tags[] = new AgilTag("Less","tag-default",NULL);
        $tags[] = new AgilTag("Stylus","tag-default",NULL);
        $tags[] = new AgilTag("Licence","tag-default",NULL);
        $tags[] = new AgilTag("Master","tag-default",NULL);
        $tags[] = new AgilTag("GIL","tag-default",NULL);
        $tags[] = new AgilTag("Hack","tag-default",NULL);
        $tags[] = new AgilTag("Architecture","tag-default",NULL);
        $tags[] = new AgilTag("AJAX","tag-default",NULL);


        foreach($tags as $t){
            $manager->persist($t);
        }
        $manager->flush();
    }

    /**
     * Ordre d'exécution des fixtures
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}