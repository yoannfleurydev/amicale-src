<?php

namespace AGIL\DefaultBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagsControllerTest extends WebTestCase {
	public function testTags() {
		$client = static::createClient();

		/* Si la route renvoie bien une liste contenant albert */
		$client->request(
			'POST',
			'/tags/search',
			array('prefix' => 'a')
		);
		$this->assertContains('Acer', $client->getResponse()->getContent());

		/* Si la suppression fonctionne bien */
		/* Attention, vous devez avoir le tag Web dans la BDD */
		$client->request(
			'POST',
			'/tags/remove',
			array('tagName' => 'Web')
		);
		$this->assertTrue($client->getResponse()->isSuccessful());
	}
}