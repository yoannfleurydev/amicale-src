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


        $tags[] = new AgilTag("PHP","purple-lighter-1",$webCategory);
        $this->addReference('tagPHP', $tags[count($tags)-1]);
        $tags[] = new AgilTag("Java","red-darker-2",$logicielCategory);
        $this->addReference('tagJava', $tags[count($tags)-1]);
        $tags[] = new AgilTag("CSS","green-darker-4",$webCategory);
        $tags[] = new AgilTag("Android","green-darker-1",$mobileCategory);
        $this->addReference('tagAndroid', $tags[count($tags)-1]);
        $tags[] = new AgilTag("C++","blue-darker-5",$logicielCategory);
        $tags[] = new AgilTag("JavaScript","yellow-lighter-1",$webCategory);
        $tags[] = new AgilTag("HTML","orange-darker-2",$webCategory);
        $tags[] = new AgilTag("C","black-lighter-1",$logicielCategory);

        $tags[] = new AgilTag("OCaml","orange-lighter-1",$logicielCategory);
        $tags[] = new AgilTag("JEE","blue-lighter-1",$webCategory);
        $this->addReference('tagJEE', $tags[count($tags)-1]);
        $tags[] = new AgilTag("PL/SQL","red-lighter-2",$BDDCategory);
        $tags[] = new AgilTag("SQL","purple-darker-5",$BDDCategory);
        $tags[] = new AgilTag("Cordova ","grey-darker-2",$mobileCategory);
        $tags[] = new AgilTag("ObjectiveC","grey-lighter-1",$mobileCategory);
        $tags[] = new AgilTag("Swift","blue-lighter-3",$mobileCategory);
        $tags[] = new AgilTag("C#","primary-blue",NULL);
        $tags[] = new AgilTag("Oracle","primary-blue",NULL);
        $tags[] = new AgilTag("MySQL","primary-blue",NULL);
        $tags[] = new AgilTag("Wamp","primary-blue",NULL);
        $tags[] = new AgilTag("Mamp","primary-blue",NULL);
        $tags[] = new AgilTag("Lamp","primary-blue",NULL);
        $tags[] = new AgilTag("PHPMyAdmin","primary-blue",NULL);
        $tags[] = new AgilTag("XML","primary-blue",NULL);
        $tags[] = new AgilTag("XSL","primary-blue",NULL);
        $tags[] = new AgilTag("XSD","primary-blue",NULL);
        $tags[] = new AgilTag("UML","primary-blue",NULL);
        $tags[] = new AgilTag("Symfony","primary-blue",NULL);
        $tags[] = new AgilTag("CakePHP","primary-blue",NULL);
        $tags[] = new AgilTag("Laravel","primary-blue",NULL);
        $tags[] = new AgilTag("Silex","primary-blue",NULL);
        $tags[] = new AgilTag("Wordpress","primary-blue",NULL);
        $tags[] = new AgilTag("VBA","primary-blue",NULL);
        $tags[] = new AgilTag("Python","primary-blue",NULL);
        $tags[] = new AgilTag("Shell","primary-blue",NULL);
        $tags[] = new AgilTag("Lisp","primary-blue",NULL);
        $tags[] = new AgilTag("Git","primary-blue",NULL);
        $tags[] = new AgilTag("LUA","primary-blue",NULL);
        $tags[] = new AgilTag("Perl","primary-blue",NULL);
        $tags[] = new AgilTag("Pascal","primary-blue",NULL);
        $tags[] = new AgilTag("AngularJS","primary-blue",NULL);
        $tags[] = new AgilTag("NodeJS","primary-blue",NULL);
        $tags[] = new AgilTag("Nginx","primary-blue",NULL);
        $tags[] = new AgilTag("Apache","primary-blue",NULL);
        $tags[] = new AgilTag("Web","primary-blue",NULL);
        $tags[] = new AgilTag("Logiciel","primary-blue",NULL);
        $tags[] = new AgilTag("Photoshop","primary-blue",NULL);
        $tags[] = new AgilTag("PHPStorm","primary-blue",NULL);
        $tags[] = new AgilTag("Lightroom","primary-blue",NULL);
        $tags[] = new AgilTag("FinalCutPro","primary-blue",NULL);
        $tags[] = new AgilTag("SonyVegas","primary-blue",NULL);
        $tags[] = new AgilTag("LogicPro","primary-blue",NULL);
        $tags[] = new AgilTag("iWorks","primary-blue",NULL);
        $tags[] = new AgilTag("OpenOffice","primary-blue",NULL);
        $tags[] = new AgilTag("LibreOffice","primary-blue",NULL);
        $tags[] = new AgilTag("LaTeX","primary-blue",NULL);
        $tags[] = new AgilTag("Cobol","primary-blue",NULL);
        $tags[] = new AgilTag("Reseau","primary-blue",NULL);
        $tags[] = new AgilTag("Fortran","primary-blue",NULL);
        $tags[] = new AgilTag("Eclipse","primary-blue",NULL);
        $tags[] = new AgilTag("IntelliJ","primary-blue",NULL);
        $tags[] = new AgilTag("JSP","primary-blue",NULL);
        $tags[] = new AgilTag("Ruby","primary-blue",NULL);
        $tags[] = new AgilTag("Scala","primary-blue",NULL);
        $tags[] = new AgilTag("Unix","primary-blue",NULL);
        $tags[] = new AgilTag("Linux","primary-blue",NULL);
        $tags[] = new AgilTag("Windows","primary-blue",NULL);
        $tags[] = new AgilTag("Mac","primary-blue",NULL);
        $tags[] = new AgilTag("Vagrant","primary-blue",NULL);
        $tags[] = new AgilTag("VM","primary-blue",NULL);
        $tags[] = new AgilTag("Yacc","primary-blue",NULL);
        $tags[] = new AgilTag("Flex","primary-blue",NULL);
        $tags[] = new AgilTag("Bison","primary-blue",NULL);
        $tags[] = new AgilTag("jQuery ","primary-blue",NULL);
        $tags[] = new AgilTag("Projet","primary-blue",NULL);
        $tags[] = new AgilTag("Bootstrap","primary-blue",NULL);
        $tags[] = new AgilTag("Materialize","primary-blue",NULL);
        $tags[] = new AgilTag("Foundation","primary-blue",NULL);
        $tags[] = new AgilTag("Twitter","primary-blue",NULL);
        $tags[] = new AgilTag("Facebook","primary-blue",NULL);
        $tags[] = new AgilTag("Youtube","primary-blue",NULL);
        $tags[] = new AgilTag("SublimeText","primary-blue",NULL);
        $tags[] = new AgilTag("Atom","primary-blue",NULL);
        $tags[] = new AgilTag("NotePad","primary-blue",NULL);
        $tags[] = new AgilTag("MozillaFirefox","primary-blue",NULL);
        $tags[] = new AgilTag("InternetExplorer","primary-blue",NULL);
        $tags[] = new AgilTag("Edge","primary-blue",NULL);
        $tags[] = new AgilTag("GoogleChrome","primary-blue",NULL);
        $tags[] = new AgilTag("Safari","primary-blue",NULL);
        $tags[] = new AgilTag("Google","primary-blue",NULL);
        $tags[] = new AgilTag("iOs","primary-blue",NULL);
        $tags[] = new AgilTag("Gmail","primary-blue",NULL);
        $tags[] = new AgilTag("Dropbox","primary-blue",NULL);
        $tags[] = new AgilTag("Github","primary-blue",NULL);
        $tags[] = new AgilTag("GoogleDrive","primary-blue",NULL);
        $tags[] = new AgilTag("SourceTree","primary-blue",NULL);
        $tags[] = new AgilTag("IDE","primary-blue",NULL);
        $tags[] = new AgilTag("VisualStudio","primary-blue",NULL);
        $tags[] = new AgilTag("Test","primary-blue",NULL);
        $tags[] = new AgilTag("Debug","primary-blue",NULL);
        $tags[] = new AgilTag("Bug","primary-blue",NULL);
        $tags[] = new AgilTag("HelpMe","primary-blue",NULL);
        $tags[] = new AgilTag("Stage","primary-blue",NULL);
        $tags[] = new AgilTag("Emploi","primary-blue",NULL);
        $tags[] = new AgilTag("CDI","primary-blue",NULL);
        $tags[] = new AgilTag("CDD","primary-blue",NULL);
        $tags[] = new AgilTag("Entreprise","primary-blue",NULL);
        $tags[] = new AgilTag("Informatique","primary-blue",NULL);
        $tags[] = new AgilTag("Universite","primary-blue",NULL);
        $tags[] = new AgilTag("Rouen","primary-blue",NULL);
        $tags[] = new AgilTag("FirefoxOS","primary-blue",NULL);
        $tags[] = new AgilTag("Debian","primary-blue",NULL);
        $tags[] = new AgilTag("Ubuntu","primary-blue",NULL);
        $tags[] = new AgilTag("WindowsXP","primary-blue",NULL);
        $tags[] = new AgilTag("WindowsVista","primary-blue",NULL);
        $tags[] = new AgilTag("Windows7","primary-blue",NULL);
        $tags[] = new AgilTag("Windows8","primary-blue",NULL);
        $tags[] = new AgilTag("Windows10","primary-blue",NULL);
        $tags[] = new AgilTag("XUbuntu","primary-blue",NULL);
        $tags[] = new AgilTag("Paint","primary-blue",NULL);
        $tags[] = new AgilTag("Gimp","primary-blue",NULL);
        $tags[] = new AgilTag("ControleContinu","primary-blue",NULL);
        $tags[] = new AgilTag("ReactJS","primary-blue",NULL);
        $tags[] = new AgilTag("Grunt","primary-blue",NULL);
        $tags[] = new AgilTag("Gump","primary-blue",NULL);
        $tags[] = new AgilTag("RaspberryPI","primary-blue",NULL);
        $tags[] = new AgilTag("Raspberry","primary-blue",NULL);
        $tags[] = new AgilTag("Bit","primary-blue",NULL);
        $tags[] = new AgilTag("Byte","primary-blue",NULL);
        $tags[] = new AgilTag("SGBD","primary-blue",NULL);
        $tags[] = new AgilTag("JSON","primary-blue",NULL);
        $tags[] = new AgilTag("Securite","primary-blue",NULL);
        $tags[] = new AgilTag("Model","primary-blue",NULL);
        $tags[] = new AgilTag("View","primary-blue",NULL);
        $tags[] = new AgilTag("Controller","primary-blue",NULL);
        $tags[] = new AgilTag("MVC","primary-blue",NULL);
        $tags[] = new AgilTag("Protocole","primary-blue",NULL);
        $tags[] = new AgilTag("MVP","primary-blue",NULL);
        $tags[] = new AgilTag("Presenter","primary-blue",NULL);
        $tags[] = new AgilTag("Docker","primary-blue",NULL);
        $tags[] = new AgilTag("Tutoriel","primary-blue",NULL);
        $tags[] = new AgilTag("Systeme","primary-blue",NULL);
        $tags[] = new AgilTag("Developpeur","primary-blue",NULL);
        $tags[] = new AgilTag("Programmeur","primary-blue",NULL);
        $tags[] = new AgilTag("ASUS","primary-blue",NULL);
        $tags[] = new AgilTag("HP","primary-blue",NULL);
        $tags[] = new AgilTag("Ordinateur","primary-blue",NULL);
        $tags[] = new AgilTag("Samsung","primary-blue",NULL);
        $tags[] = new AgilTag("Dell","primary-blue",NULL);
        $tags[] = new AgilTag("Toshiba ","primary-blue",NULL);
        $tags[] = new AgilTag("Application","primary-blue",NULL);
        $tags[] = new AgilTag("Site","primary-blue",NULL);
        $tags[] = new AgilTag("Internet","primary-blue",NULL);
        $tags[] = new AgilTag("WWW","primary-blue",NULL);
        $tags[] = new AgilTag("CM","primary-blue",NULL);
        $tags[] = new AgilTag("TD","primary-blue",NULL);
        $tags[] = new AgilTag("TP","primary-blue",NULL);
        $tags[] = new AgilTag("CC","primary-blue",NULL);
        $tags[] = new AgilTag("Examen","primary-blue",NULL);
        $tags[] = new AgilTag("Faille","primary-blue",NULL);
        $tags[] = new AgilTag("Code","primary-blue",NULL);
        $tags[] = new AgilTag("PseudoCode","primary-blue",NULL);
        $tags[] = new AgilTag("W3C","primary-blue",NULL);
        $tags[] = new AgilTag("DTD","primary-blue",NULL);
        $tags[] = new AgilTag("Codage","primary-blue",NULL);
        $tags[] = new AgilTag("Agile","primary-blue",NULL);
        $tags[] = new AgilTag("Scrum","primary-blue",NULL);
        $tags[] = new AgilTag("XP","primary-blue",NULL);
        $tags[] = new AgilTag("Planning","primary-blue",NULL);
        $tags[] = new AgilTag("Opera","primary-blue",NULL);
        $tags[] = new AgilTag("Acer","primary-blue",NULL);
        $tags[] = new AgilTag("BitBucket","primary-blue",NULL);
        $tags[] = new AgilTag("BiBTeX","primary-blue",NULL);
        $tags[] = new AgilTag("Markdown","primary-blue",NULL);
        $tags[] = new AgilTag("Jade","primary-blue",NULL);
        $tags[] = new AgilTag("Twig","primary-blue",NULL);
        $tags[] = new AgilTag("Doctrine","primary-blue",NULL);
        $tags[] = new AgilTag("Composer","primary-blue",NULL);
        $tags[] = new AgilTag("ORM","primary-blue",NULL);
        $tags[] = new AgilTag("NPM","primary-blue",NULL);
        $tags[] = new AgilTag("TOR","primary-blue",NULL);
        $tags[] = new AgilTag("API","primary-blue",NULL);
        $tags[] = new AgilTag("Bower","primary-blue",NULL);
        $tags[] = new AgilTag("Package","primary-blue",NULL);
        $tags[] = new AgilTag("Django","primary-blue",NULL);
        $tags[] = new AgilTag("Drupal","primary-blue",NULL);
        $tags[] = new AgilTag("Joomla","primary-blue",NULL);
        $tags[] = new AgilTag("Hebergeur","primary-blue",NULL);
        $tags[] = new AgilTag("Serveur","primary-blue",NULL);
        $tags[] = new AgilTag("OVH","primary-blue",NULL);
        $tags[] = new AgilTag("Bash","primary-blue",NULL);
        $tags[] = new AgilTag("Technologie","primary-blue",NULL);
        $tags[] = new AgilTag("Blog","primary-blue",NULL);
        $tags[] = new AgilTag("Siri","primary-blue",NULL);
        $tags[] = new AgilTag("Ionic","primary-blue",NULL);
        $tags[] = new AgilTag("Culture","primary-blue",NULL);
        $tags[] = new AgilTag("Cortana","primary-blue",NULL);
        $tags[] = new AgilTag("ENT","primary-blue",NULL);
        $tags[] = new AgilTag("Email","primary-blue",NULL);
        $tags[] = new AgilTag("Mobile","primary-blue",NULL);
        $tags[] = new AgilTag("Tablette","primary-blue",NULL);
        $tags[] = new AgilTag("FrontEnd","primary-blue",NULL);
        $tags[] = new AgilTag("BackEnd","primary-blue",NULL);
        $tags[] = new AgilTag("Fullstack","primary-blue",NULL);
        $tags[] = new AgilTag("Proxy","primary-blue",NULL);
        $tags[] = new AgilTag("CDR","primary-blue",NULL);
        $tags[] = new AgilTag("STB","primary-blue",NULL);
        $tags[] = new AgilTag("DAL","primary-blue",NULL);
        $tags[] = new AgilTag("PDD","primary-blue",NULL);
        $tags[] = new AgilTag("ADR","primary-blue",NULL);
        $tags[] = new AgilTag("Documentation","primary-blue",NULL);
        $tags[] = new AgilTag("CodeursEnSeine","primary-blue",NULL);
        $tags[] = new AgilTag("SASS","primary-blue",NULL);
        $tags[] = new AgilTag("Less","primary-blue",NULL);
        $tags[] = new AgilTag("Stylus","primary-blue",NULL);
        $tags[] = new AgilTag("Licence","primary-blue",NULL);
        $tags[] = new AgilTag("Master","primary-blue",NULL);
        $tags[] = new AgilTag("GIL","primary-blue",NULL);
        $tags[] = new AgilTag("Hack","primary-blue",NULL);
        $tags[] = new AgilTag("Architecture","primary-blue",NULL);
        $tags[] = new AgilTag("AJAX","primary-blue",NULL);


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