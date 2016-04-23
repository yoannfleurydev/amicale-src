<?php

namespace AGIL\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AGIL\SearchBundle\Form\SearchType;

class DefaultController extends Controller
{

    /**
     * Partie Contrôleur de la page d'index du forum, qui contient les catégories
     * avec leurs descriptions ainsi que les derniers sujets
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

        $manager = $this->getDoctrine()->getManager();

        // Repository des Categories
        $categoryRepository = $manager->getRepository('AGILForumBundle:AgilForumCategory');
        $categoryList = $categoryRepository->findAll();

        $subjectRepository = $manager ->getRepository('AGILForumBundle:AgilForumSubject');

        $subjectsPerCategories[] = NULL;
        foreach($categoryList as $c){
            $subjects = $subjectRepository->findBy(array('category' => $c),array('forumSubjectPostDate' => 'desc'),5);
            $subjectsPerCategories[$c->getForumCategoryId()] = $subjects;
        }

        return $this->render('AGILForumBundle:Default:index.html.twig',
            array('categoryList' => $categoryList,'subjectsPerCategories' => $subjectsPerCategories,
                'formSearchBar' => $formSearchBar->createView()));
    }
}
