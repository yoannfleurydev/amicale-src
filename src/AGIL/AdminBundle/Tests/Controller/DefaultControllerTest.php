<?php

namespace AGIL\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {
    const SUPER_ADMIN = array(
        '_username' => 'superadmin@amicale.dev',
        '_password' => 'superadmin'
    );
    const ADMIN = array(
        '_username' => 'admin@amicale.dev',
        '_password' => 'admin'
    );
    const AMICALE = array(
        '_username' => 'amicale@amicale.dev',
        '_password' => 'amicale'
    );
    const MODERATOR = array(
        '_username' => 'moderator@amicale.dev',
        '_password' => 'moderator'
    );
    const USER = array(
        '_username' => 'user@amicale.dev',
        '_password' => 'user'
    );

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

        $form = $crawler->selectButton('_submit')->form(array('_username' => $this::SUPER_ADMIN['_username'], '_password' => $this::SUPER_ADMIN['_password']));

        // WHEN
        $this->client->submit($form);
        $this->client->followRedirect();

        // THEN
        $this->assertContains('Administration utilisateurs', $this->client->getResponse()->getContent());
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
            '_username'  => $this::USER['_username'],
            '_password'  => $this::USER['_password']
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
            '_username'  => $this::MODERATOR['_username'],
            '_password'  => $this::MODERATOR['_password']
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
            '_username'  => $this::ADMIN['_username'],
            '_password'  => $this::ADMIN['_password']
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
            '_username'  => $this::SUPER_ADMIN['_username'],
            '_password'  => $this::SUPER_ADMIN['_password']
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
            '_username'  => $this::SUPER_ADMIN['_username'],
            '_password'  => $this::SUPER_ADMIN['_password']
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
            '_username'  => $this::SUPER_ADMIN['_username'],
            '_password'  => $this::SUPER_ADMIN['_password']
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
            '_username'  => $this::ADMIN['_username'],
            '_password'  => $this::ADMIN['_password']
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
            '_username'  => $this::SUPER_ADMIN['_username'],
            '_password'  => $this::SUPER_ADMIN['_password'],
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
            '_username'  => $this::SUPER_ADMIN['_username'],
            '_password'  => $this::SUPER_ADMIN['_password'],
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

}
