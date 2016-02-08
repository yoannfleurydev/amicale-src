<?php

namespace AGIL\ForumBundle\Controller;

use AGIL\ForumBundle\Entity\AgilForumAnswer;
use AGIL\ForumBundle\Form\AnswerType;
use AGIL\ForumBundle\Form\FirstAnswerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AGIL\ForumBundle\Form\SubjectType;
use AGIL\ForumBundle\Form\DeleteSubjectType;
use AGIL\ForumBundle\Entity\AgilForumSubject;

class SubjectsController extends Controller
{


    /**
     * Vincent : Description à rédiger
     *
     * @param $idCategory
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function subjectAddAction($idCategory, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $category = $em->getRepository("AGILForumBundle:AgilForumCategory")->find($idCategory);

        $subject = new AgilForumSubject($user,$category,null,null);
        $subject->setTags(array());
        $firstPost = new AgilForumAnswer(null, $user, null);
        $firstPost->setSubject($subject);

        $form = $this->createForm(new FirstAnswerType(), $firstPost);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($firstPost);
            $em->persist($subject);
            $em->flush($subject);
            $em->flush($firstPost);

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list', array('idCategory' => $idCategory)) );
        }

        return $this->render('AGILForumBundle:Subjects:subjects_add.html.twig', array(
            'form' => $form->createView(),
            'idCategory' => $idCategory
        ));
    }

    public function subjectDeleteAction($idCategory, $idSubject, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $subject = $em->getRepository("AGILForumBundle:AgilForumSubject")->find($idSubject);

        if (!$user->hasRole('ROLE_ADMIN') and !$user->hasRole('ROLE_SUPER_ADMIN') and $subject->getUser() != $user) {
            $this->addFlash('notice', 'Permission refusée : vous n\'êtes pas l\'autheur du sujet');

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list',
                array('idCategory' => $idCategory)) );
        }

        $form = $this->createForm(new DeleteSubjectType, null);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($subject);
            $em->remove($subject);

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list',
                array('idCategory' => $idCategory)) );
        }

        return $this->render('AGILForumBundle:Subjects:subjects_delete.html.twig', array(
            'form' => $form->createView(),
            'subject' => $subject,
            'idCategory' => $idCategory,
            'idSubject' => $idSubject
        ));
    }

    /**
     * Cette fonction permet de mettre un sujet de forum "Résolu"
     *
     * @param $idCategory
     * @param $idSubject
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function subjectResolvedAction($idCategory,$idSubject)
    {
        // Manager & Repositories
        $manager = $this->getDoctrine()->getManager();
        $categoryRepository = $manager->getRepository('AGILForumBundle:AgilForumCategory');
        $subjectRepository = $manager->getRepository('AGILForumBundle:AgilForumSubject');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $category = $categoryRepository->find($idCategory);
        if ($category === null) {
            throw new NotFoundHttpException("La catégorie d'id ".$idCategory." n'existe pas.");
        }

        // Récupération de l'objet Subject par rapport à l'ID spécifié dans l'URL
        $subject = $subjectRepository->find($idSubject);
        if ($subject === null) {
            throw new NotFoundHttpException("Le sujet d'id ".$idSubject." n'existe pas.");
        }

        // On vérifie que le Subject appartient bien à cette Category
        if ($subject->getCategory() != $category) {
            throw new NotFoundHttpException("Le sujet d'id ".$idSubject." n'appartient pas à la catégorie d'id ".$idCategory);
        }

        // Si le sujet n'est pas déjà Résolu
        if(!$subject->getForumSubjectIsResolved()){

            // Si le sujet appartient bien à la personne connecté
            if($subject->getUser() == $this->get('security.context')->getToken()->getUser()){

                $subject->setForumSubjectIsResolved(true);

                // Modification du sujet dans la BDD
                $manager->persist($subject);
                $manager->flush();

                return $this->redirectToRoute('agil_forum_subject_answers', array('idCategory' => $idCategory, 'idSubject' => $idSubject));


            }else{
                throw new NotFoundHttpException("Vous essayez passer en résolu un sujet de forum qui n'est pas le votre");
            }

        }else{
            throw new NotFoundHttpException("Le sujet de forum est déjà résolu");
        }

    }


    /*private function createDeleteForm($idCategory, $idSubject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('agil_forum_subject_delete',
                array('idCategory' => $idCategory, 'idSubject' => $idSubject)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer',
                'attr' => array(
                    'onclick' => 'return confirm("Voulez-vous vraiment supprimer ce sujet?")'
                )))
            ->getForm();
    }*/
}
