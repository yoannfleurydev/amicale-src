<?php

namespace AGIL\UserBundle\Tests\Controller;

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
     * Test : Se connecter en tant que super admin
     */
    public function testLogin()
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

        $this->assertContains('Derniers sujets de forum créés', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Se connecter avec un mauvais identifiant
     */
    public function testLoginError()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'smith.john@gmail.com',
            '_password'  => 'amicale',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Erreur de connexion !', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Mot de passe perdu avec un email incorrect
     */
    public function testPasswordLostError()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/resetting/request');

        $form = $crawler->selectButton('_submit')->form(array(
            'username'  => 'smith.john@gmail.com',
        ));

        $this->client->submit($form);

        $this->assertContains('existe pas.', $this->client->getResponse()->getContent());
    }
    /**
     * Test : Mot de passe perdu avec un email
     */
    public function testPasswordLost()
    {
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/resetting/request');

        $form = $crawler->selectButton('_submit')->form(array(
            'username'  => 'amicale@amicale.dev',
        ));

        $this->client->submit($form);

        $form = $crawler->selectButton('_submit')->form(array(
            'username'  => 'amicale@amicale.dev',
        ));

        $this->client->submit($form);

        $this->assertContains('Un nouveau mot de passe a déjà été demandé pour cet utilisateur dans les dernières 24 heures.', $this->client->getResponse()->getContent());
    }


}
