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

	public function testIndexAction() {
		// Sans mettre de numéro de page, donc on veut la première
		$crawler = $this->client->request('GET', '/hall/page');
		$this->assertTrue($this->client->getResponse()->isSuccessful());

		// En indiquant la première page
		$crawler = $this->client->request('GET', '/hall/page/1');
		$this->assertTrue($this->client->getResponse()->isSuccessful());

		// TODO Tester avec un numéro de page invalide
	}

	public function testEventAction() {
		// On teste l'accès à un événement existant
		$crawler = $this->client->request('GET', '/hall/event/1');
		$this->assertTrue($this->client->getResponse()->isSuccessful());

		// TODO Tester avec un id d'événement inexistant
	}

	public function testPhotosEventAction() {
		// Avec un événement qui possède des photos
		$crawler = $this->client->request('GET', '/hall/event/1/photos');
		$this->assertTrue($this->client->getResponse()->isSuccessful());

		// TODO Tester avec un événement qui ne possède pas de photo
	}

	public function testVideosEventAction() {
		// Avec un événement qui possède des photos
		$crawler = $this->client->request('GET', '/hall/event/1/videos');
		$this->assertTrue($this->client->getResponse()->isSuccessful());

		// TODO Tester avec un événement qui ne possède pas de vidéo
	}
}
