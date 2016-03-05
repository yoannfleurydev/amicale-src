<?php

namespace AGIL\DefaultBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {

	public function testIndex() {
		$client = static::createClient();

		$client->request('GET', '/');
		$this->assertTrue($client->getResponse()->isSuccessful());
	}

	public function testMailingList() {
		// TODO Tester les mailing list
	}
}
