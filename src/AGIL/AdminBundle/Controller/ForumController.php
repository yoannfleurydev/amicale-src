<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ForumController extends Controller
{
    /**
     * Permet d'afficher les catégories existantes, afin de pouvoir en modifier une, en supprimer une
     * ou en ajouter une.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminForumCategoriesAction()
    {
        // Manager et Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');

        // Récupération de toutes les catégories
        $categories = $categoryRepository->findAll();

        return $this->render('AGILAdminBundle:Forum:admin_forum_categories.html.twig',array(
            'categories' => $categories
            ));
    }


    /**
     * Permet d'éditer le contenu d'une catégorie
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminForumCategoryEditAction($idCategory)
    {
        // Manager et Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);
        if ($category === null) {
            throw new NotFoundHttpException("La catégorie d'id ".$idCategory." n'existe pas.");
        }

        return $this->render('AGILAdminBundle:Forum:admin_forum_category_edit.html.twig',array(
            'category' => $category
        ));
    }


    /**
     * Permet de supprimer une catégorie du forum
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminForumCategoryDeleteAction($idCategory)
    {
        // Manager et Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);
        if ($category === null) {
            throw new NotFoundHttpException("La catégorie d'id ".$idCategory." n'existe pas.");
        }

        $manager->remove($category);
        $manager->flush();

        return $this->redirect( $this->generateUrl('agil_admin_forum_categories'));

    }



}
