<?php

namespace AGIL\ProfileBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// l'id 15 correspond au membre de test "amicale"
class DefaultControllerTest extends WebTestCase
{

    private $client = null;

    /**
     * Méthode qui initialise le client de test
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAccessToProfileAsVisitor() {
        $crawler = $this->request('GET', '/profile/15');

        $this->assertContains('Adresse mail : amicale@amicale.dev', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Accéder aux paramètres de profil
     */
    public function testAccessToProfileWhenConnected()
    {
        $this->client->request('GET', '/profile/15');

        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => 'amicale@amicale.dev',
            '_password' => 'amicale'
        ));

        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertContains('Adresse mail : amicale@amicale.dev', $this->client->getResponse()->getContent());
    }

    /**
     * Changer le mot de passe (Pré-condition : Accès aux paramètres de profil)
     */
    public function testEditProfilePasswordWithWrongPasswordConfirm()
    {
        $this->testAccessToProfileWhenConnected();

        $crawler = $this->client->request('GET', '/profile/edit');

        $form = $crawler->selectButton('profil_edit_form[Modifier]')->form(array(
            'profil_edit_form[password]' => 'abcd',
            'profil_edit_form[passwordConfirm]' => '1234'
        ));

        $this->client->submit($form);
        // (pas de redirection donc followRedirect)
        $this->assertContains('Erreur ! Les mots de passe ne correspondent pas !', $this->client->getResponse()->getContent());
    }

//    public function testEditNickname()
//    {
//        $this->testAccess();
//        $crawler = $this->client->request('GET', '/profile/edit');
//        $form = $crawler->selectButton('profil_edit_form[Modifier]')->form(array(
//            'profil_edit_form[username]' => 'lee'
//        ));
//
//        $this->client->submit($form);
//        $this->client->followRedirect();
//        $this->assertContains('Profil modifié.', $this->client->getResponse()->getContent());
//
//    }

//    public function testEditProfilePicture()
//    {
//        $this->testAccess();
//        $crawler = $this->client->request('GET', '/profile/edit');
//
//        $profilePicture = new UploadedFile(
//            '',
//            '',
//            ''
//        );
//    }

}
