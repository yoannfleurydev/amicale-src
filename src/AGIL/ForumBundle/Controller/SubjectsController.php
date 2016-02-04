<?php

namespace AGIL\ForumBundle\Controller;

use AGIL\ForumBundle\Entity\AgilForumAnswer;
use AGIL\ForumBundle\Form\FirstAnswerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AGIL\ForumBundle\Form\SubjectType;
use AGIL\ForumBundle\Entity\AgilForumSubject;

class SubjectsController extends Controller
{

    public function subjectsAddAction($idCategory, Request $request)
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
}
