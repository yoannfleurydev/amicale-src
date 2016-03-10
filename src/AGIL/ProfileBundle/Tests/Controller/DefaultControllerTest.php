<?php

namespace AGIL\ProfileBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// l'id 15 correspond au membre de test "amicale"
/**
 * Class DefaultControllerTest
 * @package AGIL\ProfileBundle\Tests\Controller
 */
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

    /**
     * Test : Accéder à un profil en tant que visiteur
     */
    public function testAccessToProfileAsVisitor() {
        $this->client->request('GET', '/profile/15');
        $this->client->followRedirect();
        $this->assertContains('Connexion', $this->client->getResponse()->getContent());
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
     * Test : Changer le mot de passe avec la confirmation
     * de mot de passe qui ne corréspond pas
     * (Pré-condition : Accès aux paramètres de profil)
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
        // (pas de redirection donc pas d'appel à followRedirect)
        $this->assertContains('Erreur ! Les mots de passe ne correspondent pas !', $this->client->getResponse()->getContent());
    }

//    public function testEditNickname()
//    {
//        $this->testAccessToProfileWhenConnected();
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
