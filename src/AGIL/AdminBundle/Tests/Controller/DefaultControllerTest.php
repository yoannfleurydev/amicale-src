<?php

namespace AGIL\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    private $client = null;

    /**
     * "Constructeur" qui initialise le client
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Test : Accéder à l'accueil du forum
     */
    public function testAdminHomepage()
    {
        $crawler = $this->client->request('GET', '/admin');
        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'superadmin@superadmin.fr',
            '_password'  => 'superAdmin',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Gestion utilisateur', $this->client->getResponse()->getContent());
    }


    /**
     * Test : Créer une catégorie - Editer la catégorie - Supprimer la catégorie
     *
     * Pré-condition : testAdminHomepage()
     */
    public function testAdminCategory()
    {
        // Accéder au forum
        $this->testAdminHomepage();

        /**
         * Créer une catégorie
         */
        $crawler = $this->client->request('GET', '/admin/forum/categories/');

        $form = $crawler->selectButton('forum_add_category[Ajouter]')->form();

        $form['forum_add_category[forumCategoryName]'] = "WEB";
        $form['forum_add_category[forumCategoryText]'] = "Tout ce qui concerne le monde du web";
        $form['forum_add_category[forumCategoryIcon]'] = "glyphicon-hdd";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('La catégorie a été créée', $this->client->getResponse()->getContent());


        /**
         * Editer la catégorie créée
         */
        $link = $crawler
            ->filter('#editCategoryLink') // Cherche tous les liens contenant le bouton d'id editCategoryLink
            ->eq(5) // Selectionne le 6ème trouvé
            ->link()
        ;
        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('forum_edit_category[Modifier]')->form();

        $form['forum_edit_category[forumCategoryName]'] = "Java";
        $form['forum_edit_category[forumCategoryText]'] = "Tout ce qui concerne le Java";
        $form['forum_edit_category[forumCategoryIcon]'] = "glyphicon-globe";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('La catégorie a été modifiée', $this->client->getResponse()->getContent());


        /**
         * Supprimer la catégorie créée
         */
        // L'ID = 6 correspond à la catégorie précédemment créée après avoir lancé les fixtures
        $crawler = $this->client->request('GET', '/admin/forum/categories/delete/6');
        $crawler = $this->client->followRedirect();
        $this->assertContains('La catégorie a été supprimée.', $this->client->getResponse()->getContent());

    }


}
