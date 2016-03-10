<?php

namespace AGIL\HallBundle\Tests\Controller;

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
     * Test : Accéder à l'accueil du calendrier
     */
    public function testAccessCalendarHomepageWithOutLogin()
    {
        $this->client->request('GET', '/');
        $this->assertContains('Calendrier', $this->client->getResponse()->getContent());
    }

    public function testAccessCalendarByAdress()
    {
        $crawler = $this->client->request('GET', '/hall/calendar');
        $this->client->followRedirect();
        $this->assertContains('Calendrier', $this->client->getResponse()->getContent());
    }





}
