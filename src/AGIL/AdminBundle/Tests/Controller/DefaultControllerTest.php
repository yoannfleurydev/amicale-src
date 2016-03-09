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
     * Test : Accéder à l'accueil de l'administration
     * @test
     */
    public function connect_in_admin()
    {
        $crawler = $this->client->request('GET', '/admin');
        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'superadmin@amicale.dev',
            '_password'  => 'superadmin',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Gestion utilisateur', $this->client->getResponse()->getContent());
    }


    /**
     * Test :
     * Créer une catégorie
     * Editer la catégorie
     * Supprimer la catégorie
     *
     * @test
     */
    public function use_case_category_testing()
    {
        $this->connect_in_admin();

        // ******************************************
        // Créer une catégorie
        // ******************************************
        $crawler = $this->client->request('GET', '/admin/forum/categories/');

        $form = $crawler->selectButton('forum_add_category[Ajouter]')->form();

        $form['forum_add_category[forumCategoryName]'] = "WEB";
        $form['forum_add_category[forumCategoryText]'] = "Tout ce qui concerne le monde du web";
        $form['forum_add_category[forumCategoryIcon]'] = "glyphicon glyphicon-hdd";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('La catégorie a été créée', $this->client->getResponse()->getContent());


        // ******************************************
        // Editer la catégorie créée
        // ******************************************
        $link = $crawler
            ->filter('#editCategoryLink') // Cherche tous les liens contenant le bouton d'id editCategoryLink
            ->eq(5) // Selectionne le 6ème trouvé
            ->link()
        ;
        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('forum_edit_category[Modifier]')->form();

        $form['forum_edit_category[forumCategoryName]'] = "Java";
        $form['forum_edit_category[forumCategoryText]'] = "Tout ce qui concerne le Java";
        $form['forum_edit_category[forumCategoryIcon]'] = "glyphicon glyphicon-globe";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('La catégorie a été modifiée', $this->client->getResponse()->getContent());


        // ******************************************
        // Supprimer la catégorie créée
        // ******************************************
        // L'ID = 6 correspond à la catégorie précédemment créée après avoir lancé les fixtures
        $crawler = $this->client->request('GET', '/admin/forum/categories/delete/6');
        $crawler = $this->client->followRedirect();
        $this->assertContains('La catégorie a été supprimée.', $this->client->getResponse()->getContent());

    }

    /**
     * Tenter de créer une catégorie qui a déjà un nom existant
     */
    public function create_category_with_title_already_exist()
    {
        $this->connect_in_admin();

        $crawler = $this->client->request('GET', '/admin/forum/categories/');

        $form = $crawler->selectButton('forum_add_category[Ajouter]')->form();

        $form['forum_add_category[forumCategoryName]'] = "Cours Master 1";
        $form['forum_add_category[forumCategoryText]'] = "Cette catégorie ne sera pas créée, elle existe déjà";
        $form['forum_add_category[forumCategoryIcon]'] = "glyphicon glyphicon-hdd";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Une catégorie avec ce nom existe déjà', $this->client->getResponse()->getContent());

    }




    /**
     * Test : accéder à la page admin sans être connecté
     */
    public function testNotConnected()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin');
        $crawler = $this->client->followRedirect();

        $this->assertContains('Connexion', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Se connecter en tant qu'utilisateur
     */
    public function testLoginUser()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'user@user.fr',
            '_password'  => 'user',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin');

        $this->assertContains('Access Denied.', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Se connecter en tant que modérateur
     */
    public function testLoginModerator()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'moderator@amicale.dev',
            '_password'  => 'moderator',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin');

        $this->assertContains('Access Denied.', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Se connecter en tant qu'administrateur
     */
    public function testLoginAdmin()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'admin@amicale.dev',
            '_password'  => 'admin',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin');

        $this->assertContains('Gestion utilisateur', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Se connecter en tant que super admin
     */
    public function testLoginSuperAdmin()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'amicale@amicale.dev',
            '_password'  => 'amicale',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin');

        $this->assertContains('Gestion utilisateur', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Accéder à la liste d'utilisateur
     */
    public function testUsersList()
    {
        $this->testLoginSuperAdmin();
        $crawler = $this->client->request('GET', '/admin/user/page');

        $this->assertContains('Administration utilisateurs', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Accéder à la liste d'utilisateur
     */
    public function testUsersAdminList()
    {
        $this->testLoginAdmin();
        $crawler = $this->client->request('GET', '/admin/user/page');

        $this->assertNotContains('Administrateurs', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Accéder à l'ajout d'utilisateur
     */
    public function testUsersAdd()
    {
        $this->testLoginSuperAdmin();
        $crawler = $this->client->request('GET', '/admin/user/add');
        $this->assertContains('Ajouter un membre', $this->client->getResponse()->getContent());

        $form = $crawler->selectButton('user_add_form[Inviter]')->form(array(
            'user_add_form[email]'  => 'phpUnit@example.com',
            'user_add_form[firstName]'  => 'php',
            'user_add_form[name]'  => 'Unit',
            'user_add_form[role]'  => 'ROLE_MODERATOR',
        ));
        $this->client->submit($form);

        $this->assertContains('enregistré.', $this->client->getResponse()->getContent());
    }
}
