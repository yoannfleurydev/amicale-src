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
     * @test
     */
    public function connect_forum_with_admin()
    {
        $crawler = $this->client->request('GET', '/forum/');
        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'superadmin@amicale.dev',
            '_password'  => 'superadmin',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Accueil Forum', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Accéder à l'accueil du forum en tant qu'utilisateur
     * @test
     */
    public function connect_forum_with_user()
    {
        $crawler = $this->client->request('GET', '/forum/');
        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'user@amicale.dev',
            '_password'  => 'user',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Accueil Forum', $this->client->getResponse()->getContent());
    }



    /**
     * Test :
     * Créer un sujet depuis une catégorie
     * Répondre au sujet
     * Editer une réponse
     * Supprimer le sujet
     * @test
     */

    public function use_case_forum_testing()
    {
        // ******************************************
        // Accéder au forum
        // ******************************************
        $this->connect_forum_with_admin();


        // ******************************************
        // Créer un sujet depuis une catégorie
        // ******************************************
        $crawler = $this->client->request('GET', '/forum/categories/1/page');

        $link = $crawler->selectLink('Nouveau Sujet')->link();

        $crawler = $this->client->click($link);


        $form = $crawler->selectButton('forum_add_first_answer[Ajouter]')->form();

        $form['forum_add_first_answer[subject][forumSubjectTitle]'] = "Vos retours sur PHP 7";
        $form['forum_add_first_answer[subject][forumSubjectDescription]'] = "Description";
        $form['forum_add_first_answer[subject][tags]'] = "Web PHP";
        $form['forum_add_first_answer[forumAnswerText]'] = "Salut les développeurs Web! J'aimerai avoir vos avis
        sur la version 7 de PHP, si vous êtes satisfait ou non.";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Le sujet a bien été créé', $this->client->getResponse()->getContent());


        // ******************************************
        // Répondre dans le sujet
        // ******************************************

        $form = $crawler->selectButton('forum_add_answer[Ajouter]')->form();
        $form['forum_add_answer[forumAnswerText]'] = "Ma réponse au sujet";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Ma réponse au sujet', $this->client->getResponse()->getContent());


        // ******************************************
        // Editer son deuxième message
        // ******************************************

        $link = $crawler
           ->filter('#editAnswerLink2') // Cherche tous les liens contenant l'id editAnswerLink
           ->eq(0) // Selectionne le deuxième trouvé
           ->link()
        ;
        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('forum_edit_answer[Modifier]')->form();

        $form['forum_edit_answer[forumAnswerText]'] = "J'ai modifié ma réponse au sujet";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('La réponse a bien été modifiée', $this->client->getResponse()->getContent());


        // ******************************************
        // Supprimer le sujet créé
        // ******************************************

        $crawler = $this->client->request('GET', '/forum/categories/1/page');

        $link = $crawler
           ->filter('#deleteSubjectLink1') // Cherche tous les liens contenant l'id deleteSubjectLink
           ->eq(0) // Selectionne le premier trouvé
           ->link()
        ;

        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('forum_delete_subject[Supprimer]')->form();
        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Le sujet a bien été supprimé.', $this->client->getResponse()->getContent());


    }


    /**
     * Créer un sujet en dehors des catégories
     * Passer en résolu le sujet créé
     * @test
     */
    public function create_subject_forum_from_homepage_and_resolved_it()
    {

        $this->connect_forum_with_admin();

        // ******************************************
        // Créer un sujet en dehors des catégories
        // ******************************************
        $crawler = $this->client->request('GET', '/forum');

        $crawler = $this->client->followRedirect();

        $link = $crawler->selectLink('Nouveau Sujet')->link();

        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('forum_add_first_answer_home[Ajouter]')->form();

        $form['forum_add_first_answer_home[subject][category]'] = "4";  // 4 : id de la catégorie Informatique
        $form['forum_add_first_answer_home[subject][forumSubjectTitle]'] = "Symfony, super framework";
        $form['forum_add_first_answer_home[subject][forumSubjectDescription]'] = "LE framework utilisé en France";
        $form['forum_add_first_answer_home[subject][tags]'] = "WEB PHP";
        $form['forum_add_first_answer_home[forumAnswerText]'] = "Symfony, vous en pensez-quoi ?";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Le sujet a bien été créé', $this->client->getResponse()->getContent());

        // ******************************************
        // Passer son sujet en résolu
        // ******************************************
        $link = $crawler->selectLink('Mettre comme résolu')->link();
        $crawler = $this->client->click($link);
        $crawler = $this->client->followRedirect();

        $this->assertContains('Ce sujet est résolu', $this->client->getResponse()->getContent());

    }

    /**
     * Supprimer le sujet d'un utilisateur (par un Admin)
     * @test
     */
    public function delete_subject_by_admin()
    {
        $this->connect_forum_with_admin();

        $crawler = $this->client->request('GET', '/forum/categories/1/deleteSubject/5');

        $form = $crawler->selectButton('forum_delete_subject_with_reason[Supprimer]')->form();

        $form['forum_delete_subject_with_reason[choiceReason]'] = "Abus de langage";
        $form['forum_delete_subject_with_reason[reasonOption]'] = "Eviter les insultes s'il vous plait.";

        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertContains('Le sujet a bien été supprimé.', $this->client->getResponse()->getContent());
        $this->assertContains('Mail envoyé !', $this->client->getResponse()->getContent());
    }

    /**
     * Tenter d'accéder à une catégorie inexistante
     * @test
     */
    public function access_category_non_existent()
    {
        $this->connect_forum_with_user();

        $crawler = $this->client->request('GET', '/forum/categories/123456/page');
        $crawler = $this->client->followRedirect();

        $this->assertContains("La catégorie d&#039;id 123456 n&#039;existe pas.", $this->client->getResponse()->getContent());
    }


    /**
     * Tenter d'accéder à un sujet inexistant
     * @test
     */
    public function access_subject_non_existent()
    {
        $this->connect_forum_with_user();

        $crawler = $this->client->request('GET', '/forum/categories/1/subject/123456/page');
        $crawler = $this->client->followRedirect();

        $this->assertContains("Le sujet d&#039;id 123456 n&#039;existe pas.", $this->client->getResponse()->getContent());
    }


    /**
     * Tenter d'accéder à une page d'un sujet inexistante
     * @test
     */
    public function access_answers_page_non_existent()
    {
        $this->connect_forum_with_user();

        $crawler = $this->client->request('GET', '/forum/categories/1/subject/2/page/123456');

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }


    /**
     * Test : Tenter d'éditer une réponse qui n'est pas la sienne
     * @test
     */
    public function edit_answer_which_is_not_her()
    {
        $this->connect_forum_with_user();

        $crawler = $this->client->request('GET', '/forum/categories/1/subject/2/edit/3');
        $crawler = $this->client->followRedirect();

        $this->assertContains('Permission refusée', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Tenter de supprimer un sujet qui n'est pas le sien
     * @test
     */
    public function delete_subject_which_is_not_his()
    {
        $this->connect_forum_with_user();

        $crawler = $this->client->request('GET', '/forum/categories/1/deleteSubject/3');
        $crawler = $this->client->followRedirect();

        $this->assertContains('Permission refusée', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Tenter de passer un sujet qui n'est pas le sien en résolu
     * @test
     */
    public function pass_subjet_resolved_which_is_not_his()
    {
        $this->connect_forum_with_user();


        $crawler = $this->client->request('GET', '/forum/categories/1/resolveSubject/3');
        $crawler = $this->client->followRedirect();

        $this->assertContains('Vous essayez passer en résolu un sujet de forum qui n&#039;est pas le votre', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Tenter d'accéder à un sujet qui n'appartient pas à la bonne catégorie
     * @test
     */
    public function access_subject_in_the_bad_category()
    {
        $this->connect_forum_with_user();

        $crawler = $this->client->request('GET', '/forum/categories/2/subject/3/page');
        $crawler = $this->client->followRedirect();

        $this->assertContains('Le sujet d&#039;id 3 n&#039;appartient pas à la catégorie d&#039;id 2', $this->client->getResponse()->getContent());
    }

    /**
     * Test : Tenter d'accéder à une page de sujets qui n'existe pas
     * @test
     */

    public function access_page_of_subject_which_is_not_exist()
    {
        $this->connect_forum_with_user();

        $crawler = $this->client->request('GET', '/forum/categories/1/page/400');

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

}
