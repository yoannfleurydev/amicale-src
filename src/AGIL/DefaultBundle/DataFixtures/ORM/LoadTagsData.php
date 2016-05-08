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
        $frameworkLibrary = $this->getReference('Framework et bibliothèques');
        $web = $this->getReference('Langages Web');
        $software = $this->getReference('Langages Logiciels');
        $db = $this->getReference('Base De Données');
        $mobile = $this->getReference('Mobile');
        $projects = $this->getReference('Gestion de projet');
        $ide = $this->getReference('IDE');

        /*
         * Framework et bibliothèque
         */
        $tags[] = new AgilTag('symfony', 'grey-darker-1', $frameworkLibrary);
        $this->addReference('symfony', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('angularjs', 'red', $frameworkLibrary);
        $this->addReference('angularjs', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('laravel', 'red-lighter-2', $frameworkLibrary);
        $this->addReference('laravel', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('jquery', 'blue', $frameworkLibrary);
        $this->addReference('jquery', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('bootstrap', 'purple-darker-2', $frameworkLibrary);
        $this->addReference('bootstrap', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('django', 'green-darker-4', $frameworkLibrary);
        $this->addReference('django', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('spring', 'green-lighten-2', $frameworkLibrary);
        $this->addReference('spring', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('nodejs', 'green', $frameworkLibrary);
        $this->addReference('nodejs', $tags[count($tags) - 1]);
        /*
         * Web
         */
        $tags[] = new AgilTag('html', 'orange', $web);
        $this->addReference('html', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('css', 'cyan', $web);
        $this->addReference('css', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('php', 'purple-darker-2', $web);
        $this->addReference('php', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('javascript', 'yellow', $web);
        $this->addReference('javascript', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('jee', 'red-lighter-3', $web);
        $this->addReference('jee', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('xml', 'blue-grey', $web);
        $this->addReference('xml', $tags[count($tags) - 1]);
        /*
         * Base de données
         */
        $tags[] = new AgilTag('mysql', 'blue-darker-1', $db);
        $this->addReference('mysql', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('postgresql', 'blue-darker-2', $db);
        $this->addReference('postgresql', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('oracle', 'red', $db);
        $this->addReference('oracle', $tags[count($tags) - 1]);
        /*
         * Langages Logiciels
         */
        $tags[] = new AgilTag('java', 'orange', $software);
        $this->addReference('java', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('.net', 'cyan-darker-2', $software);
        $this->addReference('.net', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('c', 'blue-grey', $software);
        $this->addReference('c', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('c++', 'blue-grey', $software);
        $this->addReference('c++', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('python', 'yellow-darker-2', $software);
        $this->addReference('python', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('vba', 'yellow-darker-2', $software);
        $this->addReference('vba', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('ruby', 'red', $software);
        $this->addReference('ruby', $tags[count($tags) - 1]);
        /*
         * Gestion de projet
         */
        $tags[] = new AgilTag('git', 'red-lighter-3', $projects);
        $this->addReference('git', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('svn', 'green-lighter-3', $projects);
        $this->addReference('svn', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('mercurial', 'grey', $projects);
        $this->addReference('mercurial', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('methodes_agiles', 'grey', $projects);
        $this->addReference('methodes_agiles', $tags[count($tags) - 1]);
        /*
         * IDE
         */
        $tags[] = new AgilTag('phpstorm', 'purple-lighter-3', $ide);
        $this->addReference('phpstorm', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('intellij', 'red-lighter-3', $ide);
        $this->addReference('intellij', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('visual_studio', 'purple-lighter-3', $ide);
        $this->addReference('visual_studio', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('netbeans', 'cyan-lighter-3', $ide);
        $this->addReference('netbeans', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('android_studio', 'green-darker-4', $ide);
        $this->addReference('android_studio', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('pycharm', 'green-darker-3', $ide);
        $this->addReference('pycharm', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('eclipse', 'purple-darker-3', $ide);
        $this->addReference('eclipse', $tags[count($tags) - 1]);
        /*
         * Mobile
         */
        $tags[] = new AgilTag('android', 'green-darker-2', $mobile);
        $this->addReference('android', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('swift', 'orange-darker-2', $mobile);
        $this->addReference('swift', $tags[count($tags) - 1]);
        $tags[] = new AgilTag('cordova', 'grey-darker-2', $mobile);
        $this->addReference('cordova', $tags[count($tags) - 1]);


        $tags[] = new AgilTag("c#","primary-blue",NULL);
        $tags[] = new AgilTag("wamp","primary-blue",NULL);
        $tags[] = new AgilTag("mamp","primary-blue",NULL);
        $tags[] = new AgilTag("lamp","primary-blue",NULL);
        $tags[] = new AgilTag("phpmyadmin","primary-blue",NULL);
        $tags[] = new AgilTag("xsl","primary-blue",NULL);
        $tags[] = new AgilTag("xsd","primary-blue",NULL);
        $tags[] = new AgilTag("uml","primary-blue",NULL);
        $tags[] = new AgilTag("cakephp","primary-blue",NULL);
        $tags[] = new AgilTag("silex","primary-blue",NULL);
        $tags[] = new AgilTag("wordpress","primary-blue",NULL);
        $tags[] = new AgilTag("shell","primary-blue",NULL);
        $tags[] = new AgilTag("lisp","primary-blue",NULL);
        $tags[] = new AgilTag("lua","primary-blue",NULL);
        $tags[] = new AgilTag("perl","primary-blue",NULL);
        $tags[] = new AgilTag("pascal","primary-blue",NULL);
        $tags[] = new AgilTag("nginx","primary-blue",NULL);
        $tags[] = new AgilTag("apache","primary-blue",NULL);
        $tags[] = new AgilTag("web","primary-blue",NULL);
        $tags[] = new AgilTag("logiciel","primary-blue",NULL);
        $tags[] = new AgilTag("photoshop","primary-blue",NULL);
        $tags[] = new AgilTag("lightroom","primary-blue",NULL);
        $tags[] = new AgilTag("finalcutpro","primary-blue",NULL);
        $tags[] = new AgilTag("sonyvegas","primary-blue",NULL);
        $tags[] = new AgilTag("logicpro","primary-blue",NULL);
        $tags[] = new AgilTag("iworks","primary-blue",NULL);
        $tags[] = new AgilTag("openoffice","primary-blue",NULL);
        $tags[] = new AgilTag("libreoffice","primary-blue",NULL);
        $tags[] = new AgilTag("latex","primary-blue",NULL);
        $tags[] = new AgilTag("cobol","primary-blue",NULL);
        $tags[] = new AgilTag("reseau","primary-blue",NULL);
        $tags[] = new AgilTag("fortran","primary-blue",NULL);
        $tags[] = new AgilTag("jsp","primary-blue",NULL);
        $tags[] = new AgilTag("scala","primary-blue",NULL);
        $tags[] = new AgilTag("unix","primary-blue",NULL);
        $tags[] = new AgilTag("linux","primary-blue",NULL);
        $tags[] = new AgilTag("windows","primary-blue",NULL);
        $tags[] = new AgilTag("mac","primary-blue",NULL);
        $tags[] = new AgilTag("vagrant","primary-blue",NULL);
        $tags[] = new AgilTag("vm","primary-blue",NULL);
        $tags[] = new AgilTag("yacc","primary-blue",NULL);
        $tags[] = new AgilTag("flex","primary-blue",NULL);
        $tags[] = new AgilTag("bison","primary-blue",NULL);
        $tags[] = new AgilTag("projet","primary-blue",NULL);
        $tags[] = new AgilTag("materialize","primary-blue",NULL);
        $tags[] = new AgilTag("foundation","primary-blue",NULL);
        $tags[] = new AgilTag("twitter","primary-blue",NULL);
        $tags[] = new AgilTag("facebook","primary-blue",NULL);
        $tags[] = new AgilTag("youtube","primary-blue",NULL);
        $tags[] = new AgilTag("sublimeText","primary-blue",NULL);
        $tags[] = new AgilTag("atom","primary-blue",NULL);
        $tags[] = new AgilTag("notepad","primary-blue",NULL);
        $tags[] = new AgilTag("mozillafirefox","primary-blue",NULL);
        $tags[] = new AgilTag("internetexplorer","primary-blue",NULL);
        $tags[] = new AgilTag("edge","primary-blue",NULL);
        $tags[] = new AgilTag("googlechrome","primary-blue",NULL);
        $tags[] = new AgilTag("safari","primary-blue",NULL);
        $tags[] = new AgilTag("google","primary-blue",NULL);
        $tags[] = new AgilTag("ios","primary-blue",NULL);
        $tags[] = new AgilTag("gmail","primary-blue",NULL);
        $tags[] = new AgilTag("dropbox","primary-blue",NULL);
        $tags[] = new AgilTag("github","primary-blue",NULL);
        $tags[] = new AgilTag("googledrive","primary-blue",NULL);
        $tags[] = new AgilTag("sourcetree","primary-blue",NULL);
        $tags[] = new AgilTag("ide","primary-blue",NULL);
        $tags[] = new AgilTag("test","primary-blue",NULL);
        $tags[] = new AgilTag("debug","primary-blue",NULL);
        $tags[] = new AgilTag("bug","primary-blue",NULL);
        $tags[] = new AgilTag("helpme","primary-blue",NULL);
        $tags[] = new AgilTag("stage","primary-blue",NULL);
        $tags[] = new AgilTag("emploi","primary-blue",NULL);
        $tags[] = new AgilTag("cdi","primary-blue",NULL);
        $tags[] = new AgilTag("cdd","primary-blue",NULL);
        $tags[] = new AgilTag("entreprise","primary-blue",NULL);
        $tags[] = new AgilTag("informatique","primary-blue",NULL);
        $tags[] = new AgilTag("universite","primary-blue",NULL);
        $tags[] = new AgilTag("rouen","primary-blue",NULL);
        $tags[] = new AgilTag("firefoxos","primary-blue",NULL);
        $tags[] = new AgilTag("debian","primary-blue",NULL);
        $tags[] = new AgilTag("ubuntu","primary-blue",NULL);
        $tags[] = new AgilTag("windowsxp","primary-blue",NULL);
        $tags[] = new AgilTag("windowsvista","primary-blue",NULL);
        $tags[] = new AgilTag("windows7","primary-blue",NULL);
        $tags[] = new AgilTag("windows8","primary-blue",NULL);
        $tags[] = new AgilTag("windows10","primary-blue",NULL);
        $tags[] = new AgilTag("xubuntu","primary-blue",NULL);
        $tags[] = new AgilTag("paint","primary-blue",NULL);
        $tags[] = new AgilTag("gimp","primary-blue",NULL);
        $tags[] = new AgilTag("controlecontinu","primary-blue",NULL);
        $tags[] = new AgilTag("reactjs","primary-blue",NULL);
        $tags[] = new AgilTag("grunt","primary-blue",NULL);
        $tags[] = new AgilTag("gump","primary-blue",NULL);
        $tags[] = new AgilTag("raspberrypi","primary-blue",NULL);
        $tags[] = new AgilTag("raspberry","primary-blue",NULL);
        $tags[] = new AgilTag("bit","primary-blue",NULL);
        $tags[] = new AgilTag("byte","primary-blue",NULL);
        $tags[] = new AgilTag("sgbd","primary-blue",NULL);
        $tags[] = new AgilTag("json","primary-blue",NULL);
        $tags[] = new AgilTag("securite","primary-blue",NULL);
        $tags[] = new AgilTag("model","primary-blue",NULL);
        $tags[] = new AgilTag("view","primary-blue",NULL);
        $tags[] = new AgilTag("controller","primary-blue",NULL);
        $tags[] = new AgilTag("mvc","primary-blue",NULL);
        $tags[] = new AgilTag("protocole","primary-blue",NULL);
        $tags[] = new AgilTag("mvp","primary-blue",NULL);
        $tags[] = new AgilTag("presenter","primary-blue",NULL);
        $tags[] = new AgilTag("docker","primary-blue",NULL);
        $tags[] = new AgilTag("tutoriel","primary-blue",NULL);
        $tags[] = new AgilTag("systeme","primary-blue",NULL);
        $tags[] = new AgilTag("developpeur","primary-blue",NULL);
        $tags[] = new AgilTag("programmeur","primary-blue",NULL);
        $tags[] = new AgilTag("asus","primary-blue",NULL);
        $tags[] = new AgilTag("hp","primary-blue",NULL);
        $tags[] = new AgilTag("ordinateur","primary-blue",NULL);
        $tags[] = new AgilTag("samsung","primary-blue",NULL);
        $tags[] = new AgilTag("dell","primary-blue",NULL);
        $tags[] = new AgilTag("toshiba ","primary-blue",NULL);
        $tags[] = new AgilTag("application","primary-blue",NULL);
        $tags[] = new AgilTag("site","primary-blue",NULL);
        $tags[] = new AgilTag("internet","primary-blue",NULL);
        $tags[] = new AgilTag("www","primary-blue",NULL);
        $tags[] = new AgilTag("cm","primary-blue",NULL);
        $tags[] = new AgilTag("td","primary-blue",NULL);
        $tags[] = new AgilTag("tp","primary-blue",NULL);
        $tags[] = new AgilTag("cc","primary-blue",NULL);
        $tags[] = new AgilTag("examen","primary-blue",NULL);
        $tags[] = new AgilTag("faille","primary-blue",NULL);
        $tags[] = new AgilTag("code","primary-blue",NULL);
        $tags[] = new AgilTag("pseudocode","primary-blue",NULL);
        $tags[] = new AgilTag("w3c","primary-blue",NULL);
        $tags[] = new AgilTag("dtd","primary-blue",NULL);
        $tags[] = new AgilTag("codage","primary-blue",NULL);
        $tags[] = new AgilTag("agile","primary-blue",NULL);
        $tags[] = new AgilTag("scrum","primary-blue",NULL);
        $tags[] = new AgilTag("xp","primary-blue",NULL);
        $tags[] = new AgilTag("planning","primary-blue",NULL);
        $tags[] = new AgilTag("opera","primary-blue",NULL);
        $tags[] = new AgilTag("acer","primary-blue",NULL);
        $tags[] = new AgilTag("bitbucket","primary-blue",NULL);
        $tags[] = new AgilTag("bibtex","primary-blue",NULL);
        $tags[] = new AgilTag("markdown","primary-blue",NULL);
        $tags[] = new AgilTag("jade","primary-blue",NULL);
        $tags[] = new AgilTag("twig","primary-blue",NULL);
        $tags[] = new AgilTag("doctrine","primary-blue",NULL);
        $tags[] = new AgilTag("composer","primary-blue",NULL);
        $tags[] = new AgilTag("orm","primary-blue",NULL);
        $tags[] = new AgilTag("npm","primary-blue",NULL);
        $tags[] = new AgilTag("tor","primary-blue",NULL);
        $tags[] = new AgilTag("api","primary-blue",NULL);
        $tags[] = new AgilTag("bower","primary-blue",NULL);
        $tags[] = new AgilTag("package","primary-blue",NULL);
        $tags[] = new AgilTag("drupal","primary-blue",NULL);
        $tags[] = new AgilTag("joomla","primary-blue",NULL);
        $tags[] = new AgilTag("hebergeur","primary-blue",NULL);
        $tags[] = new AgilTag("serveur","primary-blue",NULL);
        $tags[] = new AgilTag("ovh","primary-blue",NULL);
        $tags[] = new AgilTag("bash","primary-blue",NULL);
        $tags[] = new AgilTag("technologie","primary-blue",NULL);
        $tags[] = new AgilTag("blog","primary-blue",NULL);
        $tags[] = new AgilTag("siri","primary-blue",NULL);
        $tags[] = new AgilTag("ionic","primary-blue",NULL);
        $tags[] = new AgilTag("culture","primary-blue",NULL);
        $tags[] = new AgilTag("cortana","primary-blue",NULL);
        $tags[] = new AgilTag("ent","primary-blue",NULL);
        $tags[] = new AgilTag("email","primary-blue",NULL);
        $tags[] = new AgilTag("mobile","primary-blue",NULL);
        $tags[] = new AgilTag("tablette","primary-blue",NULL);
        $tags[] = new AgilTag("frontend","primary-blue",NULL);
        $tags[] = new AgilTag("backend","primary-blue",NULL);
        $tags[] = new AgilTag("fullstack","primary-blue",NULL);
        $tags[] = new AgilTag("proxy","primary-blue",NULL);
        $tags[] = new AgilTag("cdr","primary-blue",NULL);
        $tags[] = new AgilTag("stb","primary-blue",NULL);
        $tags[] = new AgilTag("dal","primary-blue",NULL);
        $tags[] = new AgilTag("pdd","primary-blue",NULL);
        $tags[] = new AgilTag("adr","primary-blue",NULL);
        $tags[] = new AgilTag("documentation","primary-blue",NULL);
        $tags[] = new AgilTag("codeursenseine","primary-blue",NULL);
        $tags[] = new AgilTag("sass","primary-blue",NULL);
        $tags[] = new AgilTag("less","primary-blue",NULL);
        $tags[] = new AgilTag("stylus","primary-blue",NULL);
        $tags[] = new AgilTag("licence","primary-blue",NULL);
        $tags[] = new AgilTag("master","primary-blue",NULL);
        $tags[] = new AgilTag("gil","primary-blue",NULL);
        $tags[] = new AgilTag("hack","primary-blue",NULL);
        $tags[] = new AgilTag("architecture","primary-blue",NULL);
        $tags[] = new AgilTag("ajax","primary-blue",NULL);


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