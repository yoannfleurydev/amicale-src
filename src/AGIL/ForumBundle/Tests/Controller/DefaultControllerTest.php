<?php

namespace AGIL\ForumBundle\Tests\Controller;

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
     * Test : Accéder à l'accueil du forum
     */
    public function testForumHomepage()
    {
        $crawler = $this->client->request('GET', '/forum/');
        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'superadmin@superadmin.fr',
            '_password'  => 'superAdmin',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Accueil Forum', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Créer un sujet (depuis une catégorie)
     *
     * Pré-condition : testForumHomepage()
     */
    public function testForumAddSubject()
    {
        $this->testForumHomepage();

        // Continuer le test (Déplacement dans une catégorie etc...)
    }


}
