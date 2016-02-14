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