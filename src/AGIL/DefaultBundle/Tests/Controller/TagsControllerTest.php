<?php

namespace AGIL\DefaultBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagsControllerTest extends WebTestCase {
	private $client;

	/**
	 * "Constructeur" qui initialise le client
	 */
	public function setUp() {
		$this->client = static::createClient();
	}

	/**
	 * Teste si les routes sont accessibles or xhr
	 * @Test access to routes
	 */
	public function testRoutesNotAccessible() {
		/* Vérifier que l'accès à la route sans requête ajax n'est pas autorisé */
		$url = $this->client->getContainer()->get('router')->generate('agil_tags_search');
		$this->client->request(
			'GET',
			$url,
			array('prefix' => 'a')
		);
		$this->assertTrue($this->client->getResponse()->isNotFound());

		/* Vérifier que l'accès à la route sans requête ajax n'est pas autorisé */
		$url = $this->client->getContainer()->get('router')->generate('agil_tags_remove');
		$this->client->request(
			'GET',
			$url,
			array('tagName' => 'Web')
		);
		$this->assertTrue($this->client->getResponse()->isNotFound());
	}

	/**
	 * Teste que les tags alpha numériques sont enregistrés
	 * @Test corrects tags are registred
	 */
	public function testTagsAreRegistred() {
		/* Créer un client connecté en tant qu'user */
		$url = $this->client->getContainer()->get('router')->generate('fos_user_profile_show');

		$crawler = $this->client->request(
			'GET',
			$url
		);

		$form = $crawler->selectButton('_submit')->form(array(
			'_username' => 'user@amicale.dev',
			'_password' => 'user',
		));

		$this->client->submit($form);
		$this->client->followRedirect();

		/* Vérifier que les tags sont bien enregistrés */
		$url = $this->client->getContainer()->get('router')->generate('agil_forum_subject_add_home');
		$crawler = $this->client->request(
			'GET',
			$url
		);
		$form = $crawler->selectButton('forum_add_first_answer_home[Ajouter]')->form();
		$form['forum_add_first_answer_home[subject][forumSubjectTitle]'] = 'Test correct des tags';
		$form['forum_add_first_answer_home[subject][forumSubjectDescription]'] = 'On écrit des tags corrects';
		$form['forum_add_first_answer_home[forumAnswerText]'] = 'Un sujet avec des tags corrects !';

		$form['forum_add_first_answer_home[subject][tags]'] = 'PHP Java Acer UnTagInexistant35';

		$this->client->submit($form);
		$this->client->followRedirect();

		$content = $this->client->getResponse()->getContent();
		$this->assertContains('Le sujet a bien été créé', $content);
		$this->assertContains('PHP', $content);
		$this->assertContains('JAVA', $content);
		$this->assertContains('ACER', $content);
		$this->assertContains('UNTAGINEXISTANT35', $content);
	}

	/**
	 * Teste que les tags non alpha numériques ne sont pas enregistrés
	 * @Test incorrects tags are not registred
	 */
	public function testTagsAreNotRegistred() {
		$url = $this->client->getContainer()->get('router')->generate('fos_user_profile_show');

		$crawler = $this->client->request(
			'GET',
			$url
		);

		$form = $crawler->selectButton('_submit')->form(array(
			'_username' => 'user@amicale.dev',
			'_password' => 'user',
		));

		$this->client->submit($form);
		$this->client->followRedirect();

		/* Vérifier que les tags non alpha numériques ne sont pas enregistrés */
		$url = $this->client->getContainer()->get('router')->generate('agil_forum_subject_add_home');
		$crawler = $this->client->request(
			'GET',
			$url
		);
		$form = $crawler->selectButton('forum_add_first_answer_home[Ajouter]')->form();
		$form['forum_add_first_answer_home[subject][forumSubjectTitle]'] = 'Test incorrect des tags';
		$form['forum_add_first_answer_home[subject][forumSubjectDescription]'] = 'On écrit des tags incorrects';
		$form['forum_add_first_answer_home[forumAnswerText]'] = 'Un sujet avec des tags incorrects !';

		$form['forum_add_first_answer_home[subject][tags]'] = '//unComment --anotherComment #anotherComment al|()ric';

		$this->client->submit($form);
		$this->client->followRedirect();

		$content =  $this->client->getResponse()->getContent();
		$this->assertContains('Le sujet a bien été créé', $content);
		$this->assertNotContains('//unComment', $content);
		$this->assertNotContains('--anotherComment', $content);
		$this->assertNotContains('#anotherComment', $content);
		$this->assertNotContains('<script>', $content);
		$this->assertNotContains('al|()ric', $content);
	}
}