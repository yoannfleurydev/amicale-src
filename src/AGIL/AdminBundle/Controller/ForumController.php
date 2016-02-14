<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use AGIL\AdminBundle\Form\EditCategoryType;
use AGIL\AdminBundle\Form\AddCategoryType;
use AGIL\ForumBundle\Entity\AgilForumCategory;



class ForumController extends Controller
{
    /**
     * Permet d'afficher les catégories existantes, afin de pouvoir en modifier une, en supprimer une
     * ou en ajouter une.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminForumCategoriesAction(Request $request)
    {
        // Manager et Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');

        // Récupération de toutes les catégories
        $categories = $categoryRepository->findAll();

        // Pour chaque catégorie, on récupère le nombre de sujets
        $nbSubjectsPerCategory[] = NULL;
        foreach($categories as $c){
            $nbSubjectsPerCategory[$c->getForumCategoryId()] =  $categoryRepository->getCountSubjectsInCategory($c->getForumCategoryId());
        }

        // Formulaire d'ajout de catégorie
        $category = new AgilForumCategory(null,null,null);

        $form = $this->createForm(new AddCategoryType(), $category);

        $form->handleRequest($request);
        if ($form->isValid()) {

            // Est ce qu'une catégorie du même nom existe ?
            $categoryExist = $categoryRepository->findBy(array('forumCategoryName' => $category->getForumCategoryName()));
            if($categoryExist == null){
                $manager->persist($category);
                $manager->flush($category);
                $this->addFlash('success', "La catégorie a été créée");
            }else{
                $this->addFlash('warning', "Une catégorie avec ce nom existe déjà");
            }

            return $this->redirectToRoute('agil_admin_forum_categories');
        }

        return $this->render('AGILAdminBundle:Forum:admin_forum_categories.html.twig',array(
            'categories' => $categories, 'form' => $form->createView(),
            'nbSubjectsPerCategory' => $nbSubjectsPerCategory
            ));
    }


    /**
     * Permet d'éditer le contenu d'une catégorie
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminForumCategoryEditAction($idCategory,Request $request)
    {
        // Manager et Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager ->getRepository('AGILForumBundle:AgilForumCategory');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);
        if ($category === null) {
            $this->addFlash('warning', "La catégorie d'id " .$idCategory. " n'existe pas.");
            return $this->redirectToRoute('agil_admin_forum_categories');
        }

        $categoryName = $category->getForumCategoryName();

        $form = $this->createForm(new EditCategoryType(), $category);

        $form->handleRequest($request);
        if ($form->isValid()) {

            // Est ce qu'une catégorie du même nom existe ?
            $categoryExist = $categoryRepository->findBy(array('forumCategoryName' => $category->getForumCategoryName()));
            if($categoryExist == null or $category->getForumCategoryName() == $categoryName){
                $manager->persist($category);
                $manager->flush($category);
                $this->addFlash('success', "La catégorie a été modifiée");
                return $this->redirectToRoute('agil_admin_forum_categories');
            }else{
                $this->addFlash('warning', "Une catégorie avec ce nom existe déjà");
                return $this->redirectToRoute('agil_admin_forum_category_edit',array('idCategory' => $idCategory));
            }

        }


        return $this->render('AGILAdminBundle:Forum:admin_forum_category_edit.html.twig',array(
            'category' => $category, 'form' => $form->createView()
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
            $this->addFlash('warning', "La catégorie d'id ".$idCategory." n'existe pas.");
            return $this->redirect( $this->generateUrl('agil_admin_forum_categories'));
        }

        $manager->remove($category);
        $manager->flush();

        $this->addFlash('success', "La catégorie a été supprimée.");
        return $this->redirect( $this->generateUrl('agil_admin_forum_categories'));

    }



}
