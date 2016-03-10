<?php

namespace AGIL\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {
    const SUPER_ADMIN_USERNAME = 'superadmin@amicale.dev';
    const SUPER_ADMIN_PASSWORD = 'superadmin';

    const ADMIN_USERNAME = 'admin@amicale.dev';
    const ADMIN_PASSWORD = 'admin';

    const AMICALE_USERNAME = 'amicale@amicale.dev';
    const AMICALE_PASSWORD = 'amicale';

    const MODERATOR_USERNAME = 'moderator@amicale.dev';
    const MODERATOR_PASSWORD = 'moderator';

    const USER_USERNAME = 'user@amicale.dev';
    const USER_PASSWORD = 'user';

    private $client = null;

    /**
     * @before
     */
    public function setUp() {
        $this->client = static::createClient();
    }

    /**
     * @test superadmin connection and its rights
     */
    public function superadmin_connection_and_rights() {
        // GIVEN
        $this->client->request('GET', '/admin/user/page');
        $crawler = $this->client->followRedirect();
        $form = $crawler->selectButton('_submit')->form(
            array(
                '_username' => $this::SUPER_ADMIN_USERNAME,
                '_password' => $this::SUPER_ADMIN_PASSWORD
            )
        );
        // WHEN
        $this->client->submit($form);
        $this->client->followRedirect();
        // THEN
        $this->assertContains('Administration utilisateurs', $this->client->getResponse()->getContent());
    }

    /**
     * @test
     * Tenter de créer une catégorie qui a déjà un nom existant
     */
    public function create_category_with_title_already_exist()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => $this::SUPER_ADMIN_USERNAME,
            '_password' => $this::SUPER_ADMIN_PASSWORD
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin/forum/categories/');

        $form = $crawler->selectButton('forum_add_category[Ajouter]')->form();

        $form['forum_add_category[forumCategoryName]'] = "Cours Master 1";
        $form['forum_add_category[forumCategoryText]'] = "Cette catégorie ne sera pas créée, elle existe déjà";
        $form['forum_add_category[forumCategoryIcon]'] = "glyphicon glyphicon-hdd";

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->assertContains('Une catégorie avec ce nom existe déjà', $this->client->getResponse()->getContent());

    }

    /**
     * @test
     */
    public function redirect_from_admin_when_not_connected()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin');
        $crawler = $this->client->followRedirect();

        $this->assertContains('Connexion', $this->client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function user_login_cant_access_administration_panel() {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::USER_USERNAME,
            '_password'  => $this::USER_PASSWORD
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin');

        $this->assertTrue($this->client->getResponse()->isForbidden());
    }


    /**
     * @test
     */
    public function test_login_moderator()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::MODERATOR_USERNAME,
            '_password'  => $this::MODERATOR_PASSWORD
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->client->request('GET', '/admin');

        $this->assertContains('Access Denied.', $this->client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function test_login_admin()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::ADMIN_USERNAME,
            '_password'  => $this::ADMIN_PASSWORD
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin');

        $this->assertContains('Gestion utilisateur', $this->client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function test_login_superAdmin()
    {
        $this->client->request('GET', '/logout');
        $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::SUPER_ADMIN_USERNAME,
            '_password'  => $this::SUPER_ADMIN_PASSWORD
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->client->request('GET', '/admin');

        $this->assertContains('Gestion utilisateur', $this->client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function user_list_when_superadmin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::SUPER_ADMIN_USERNAME,
            '_password'  => $this::SUPER_ADMIN_PASSWORD
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->client->request('GET', '/admin/user/page');

        $this->assertContains('Administration utilisateurs', $this->client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function admin_list_when_superadmin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::SUPER_ADMIN_USERNAME,
            '_password'  => $this::SUPER_ADMIN_PASSWORD
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->client->request('GET', '/admin/user/page');

        $this->assertContains('Administrateurs', $this->client->getResponse()->getContent());
    }

    public function admin_list_when_admin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::ADMIN_USERNAME,
            '_password'  => $this::ADMIN_PASSWORD
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $this->client->request('GET', '/admin/user/page');

        $this->assertNotContains('Administrateurs', $this->client->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function add_user_should_work() {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::SUPER_ADMIN_USERNAME,
            '_password'  => $this::SUPER_ADMIN_PASSWORD
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin/user/add');
        $this->assertContains('Ajouter un membre', $this->client->getResponse()->getContent());

        $form = $crawler->selectButton('user_add_form[Inviter]')->form(array(
            'user_add_form[email]'  => 'phpunit@admicale.dev',
            'user_add_form[firstName]'  => 'Php',
            'user_add_form[name]'  => 'Unit',
            'user_add_form[role]'  => 'ROLE_USER',
        ));
        $this->client->submit($form);

        $this->assertContains('alert-success', $this->client->getResponse()->getContent());
    }

    /**
     * @test
     * @depends add_user_should_work
     */
    public function add_user_should_not_work_because_it_already_exist() {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => $this::SUPER_ADMIN_USERNAME,
            '_password'  => $this::SUPER_ADMIN_PASSWORD,
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin/user/add');
        $this->assertContains('Ajouter un membre', $this->client->getResponse()->getContent());

        $form = $crawler->selectButton('user_add_form[Inviter]')->form(array(
            'user_add_form[email]'  => 'phpunit@admicale.dev',
            'user_add_form[firstName]'  => 'Php',
            'user_add_form[name]'  => 'Unit',
            'user_add_form[role]'  => 'ROLE_USER',
        ));
        $this->client->submit($form);

        $this->assertContains('alert-warning', $this->client->getResponse()->getContent());
    }

    /**
     * Test :
     * Créer une catégorie
     * Editer la catégorie
     * Supprimer la catégorie
     *
     * @test
     *//*
    public function use_case_category_testing() {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => 'user@amicale.dev',
            '_password' => 'user'
        ));

        $this->client->submit($form);
        $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/admin/forum/categories/');

        $form = $crawler->selectButton('forum_add_category[Ajouter]')->form();

        $form['forum_add_category[forumCategoryName]'] = "WEB";
        $form['forum_add_category[forumCategoryText]'] = "Tout ce qui concerne le monde du web";
        $form['forum_add_category[forumCategoryIcon]'] = "glyphicon glyphicon-hdd";

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('La catégorie a été créée', $this->client->getResponse()->getContent());

/*
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
        $this->assertContains('La catégorie a été supprimée.', $this->client->getResponse()->getContent());*/
   // }
}
