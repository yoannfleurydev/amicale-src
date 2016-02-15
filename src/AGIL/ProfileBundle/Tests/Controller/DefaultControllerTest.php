<?php

namespace AGIL\ProfileBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * Test : Accéder aux paramètres de profil
     * username et password à changer selon votre configuration perso
     */
    public function testAccess()
    {
        $this->client->request('GET', '/profile/edit');

        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => 'chuck@norris.dev',
            '_password' => 'chuck'
        ));

        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertContains('Modifier l\'adresse email :', $this->client->getResponse()->getContent());
    }

    public function testEditNickname()
    {
        $this->testAccess();
        $crawler = $this->client->request('GET', '/profile/edit');
        $form = $crawler->selectButton('profil_edit_form[Modifier]')->form(array(
            'profil_edit_form[username]' => 'lee'
        ));

        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertContains('Profil modifié.', $this->client->getResponse()->getContent());

    }

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

    /**
     * Changer le mot de passe (Pré-condition : Accès aux paramètres de profil)
     */
//    public function testEditPassword()
//    {
//        $this->testAccess();
//
//        $crawler = $this->client->request('GET', '/profile/edit');
//
//        $form = $crawler->selectButton('profil_edit_form[Modifier]')->form(array(
//            'profil_edit_form[password]' => 'amicaleModificationMDP',
//            'profil_edit_form[passwordConfirm]' => 'amicaleModificationMDP'
//        ));
//
//        $this->client->submit($form);
//        $this->client->followRedirect();
//        $this->assertNotContains('Erreur ! Les mots de passe ne correspondent pas !', $this->client->getResponse()->getContent());
//    }
}
