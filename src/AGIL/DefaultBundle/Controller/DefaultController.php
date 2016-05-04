<?php

namespace AGIL\DefaultBundle\Controller;

use AGIL\DefaultBundle\Form\IdeaType;
use AGIL\ForumBundle\Entity\AgilForumAnswer;
use AGIL\ForumBundle\Entity\AgilForumCategory;
use AGIL\ForumBundle\Entity\AgilForumSubject;
use AGIL\SearchBundle\Form\SearchType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * Méthode qui construit la page d'accueil
     * @param Request $request
     * @return Response
     */
    public function indexAction()
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(new IdeaType(), null);
        $form->handleRequest($this->container->get('request_stack')->getCurrentRequest());

        if ($form->isValid()) {
            $this->ideaBoxAddAction($manager, $form);
            $form = $this->createForm(new IdeaType(), null);
        }

        // Repository des Sujets de forum
        $subjectRepository = $manager->getRepository('AGILForumBundle:AgilForumSubject');
        $offerRepository = $manager->getRepository('AGILOfferBundle:AgilOffer');
        $chatTablesRepository = $manager->getRepository('AGILChatBundle:AgilChatTable');

        // Récupération des 3 derniers sujets de forum créés
        $lastSubjects = $subjectRepository->findBy(array(),array('forumSubjectPostDate' => 'desc'),3);
        // Récupération des 3 dernières annonces créés
        $lastOffers = $offerRepository->findBy(array('offerPublish' => true), array('offerPostDate' => 'desc'), 3);
        // Récupération des 3 dernières tables créés
        $lastTables= $chatTablesRepository->findBy(array(), array('chatTableDate' => 'desc'), 3);

        return $this->render('AGILDefaultBundle:Default:index.html.twig',
            array(
                'lastSubjects' => $lastSubjects,
                'offers' => $lastOffers,
                'formSearchBar' => $formSearchBar->createView(),
                'form' => $form->createView(),
                'lastTables' => $lastTables
            )
        );
    }

    public function creditsAction() {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());
        return $this->render('AGILDefaultBundle:Default:credits.html.twig',array('formSearchBar' => $formSearchBar->createView()));
    }

    /**
     * Cette fonction permet d'ajouter un nouveau sujet dans la boite à suggestion, dans le forum
     * @param ObjectManager $em
     * @param Form $form
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function ideaBoxAddAction(ObjectManager $em, Form $form)
    {

        $user = $this->getUser();

        $category = $em->getRepository("AGILForumBundle:AgilForumCategory")->findBy(array('forumCategoryName' => 'Boîte à idées'));
        $subject =  $em->getRepository("AGILForumBundle:AgilForumSubject")->findBy(array('forumSubjectTitle' => 'Idées en vrac'));
        if (empty($category[0])) {
            $category = new AgilForumCategory("Boîte à idées", "glyphicon-question-sign", "Une idée, une suggestion, un bug ou une question ?");
            $em->persist($category);
        } else {
            $category = $category[0];
        }
        if (empty($subject[0])) {
            $superAdmin = $em->getRepository("AGILUserBundle:AgilUser")->findByRole("ROLE_SUPER_ADMIN")[0];
            $subject = new AgilForumSubject($superAdmin, $category, "Idées en vrac", "Toutes les idées postées via l'accueil du site.", false);
            $em->persist($subject);
        } else {
            $subject = $subject[0];
        }
        $idCategory = $category->getForumCategoryId();

        $post = new AgilForumAnswer($subject, $user, $form->get('idea')->getData());
        $em->persist($post);

        $em->flush();

        $this->addFlash('success', "L'idée a bien été envoyée.");
    }
}
