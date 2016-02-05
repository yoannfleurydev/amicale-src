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
