<?php

namespace AGIL\HallBundle\Tests\Controller;


class CalendarControllerTest {

	private $client = null;

	/**
	 * Méthode qui initialise le client de test
	 */
	public function setUp() {
		$this->client = static::createClient();
	}

	public function testshowCalendarAction() {
		// Test d'accès
		$crawler = $this->client->request('GET', '/hall/calendar');
		$this->assertTrue($this->client->getResponse()->isSuccessful());
	}

	public function testGetCalendarDataAction() {
		// route : /calendar/data
		// méthode : post
		// TODO Tester la méthode avec des dates correctes

		// TODO Tester la méthode avec des dates incorrectes
	}
}