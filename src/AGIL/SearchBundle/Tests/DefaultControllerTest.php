<?php

namespace AGIL\SearchBundle\Tests\Controller;

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
     * Test : Recherche simple avec un user
     * @test
     */
    public function simple_search_with_admin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'superadmin@amicale.dev',
            '_password'  => 'superadmin',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/search?tags=php');
        $crawler = $this->client->followRedirect();

        $this->assertContains('[Projet] BDD', $this->client->getResponse()->getContent());
        $this->assertContains('Sujets de Forum', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Recherche avancée avec un user
     * @test
     */
    public function advanced_search_with_admin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'superadmin@amicale.dev',
            '_password'  => 'superadmin',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $crawler = $this->client->request('GET', '/search?tags=mobile+web&filter=offer&method=or&no=');
        $crawler = $this->client->followRedirect();

        $this->assertContains("Développeur Web Backend", $this->client->getResponse()->getContent());
    }


    /**
     * Test : Recherche simple en mode non connectée
     * @test
     */
    public function simple_search()
    {
        $crawler = $this->client->request('GET', '/search?tags=php');
        $crawler = $this->client->followRedirect();

        $this->assertContains("La recherche n'a retourné aucun résultat.", $this->client->getResponse()->getContent());
        $this->assertContains('Veuillez vous connecter pour accéder à la recherche Forum', $this->client->getResponse()->getContent());
        $this->assertContains('Veuillez vous connecter pour accéder à la recherche des Offres', $this->client->getResponse()->getContent());
        $this->assertContains('Veuillez vous connecter pour accéder à la recherche des Profils', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Recherche avancée en mode non connectée
     * @test
     */
    public function advanced_search()
    {
        $crawler = $this->client->request('GET', '/search?tags=php+java&filter=all&method=or&no=android+php+java');
        $crawler = $this->client->followRedirect();

        $this->assertContains("La recherche n'a retourné aucun résultat.", $this->client->getResponse()->getContent());
        $this->assertContains('Veuillez vous connecter pour accéder à la recherche Forum', $this->client->getResponse()->getContent());
        $this->assertContains('Veuillez vous connecter pour accéder à la recherche des Offres', $this->client->getResponse()->getContent());
        $this->assertContains('Veuillez vous connecter pour accéder à la recherche des Profils', $this->client->getResponse()->getContent());
    }


}
