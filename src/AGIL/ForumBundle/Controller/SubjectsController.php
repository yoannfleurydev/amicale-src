<?php

namespace AGIL\ForumBundle\Controller;

use AGIL\DefaultBundle\Entity\AgilTag;
use AGIL\ForumBundle\Entity\AgilForumAnswer;
use AGIL\ForumBundle\Form\AnswerType;
use AGIL\ForumBundle\Form\DeleteSubjectAdminType;
use AGIL\ForumBundle\Form\FirstAnswerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AGIL\ForumBundle\Form\DeleteSubjectType;
use AGIL\ForumBundle\Entity\AgilForumSubject;

class SubjectsController extends Controller
{
    /**
     * Cette fonction permet d'ajouter un nouveau sujet dans le forum
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
        if ($category === null) {
            $this->addFlash('warning', "La catégorie d'id " . $idCategory . " n'existe pas.");
            return $this->redirect( $this->generateUrl('agil_forum_homepage'));
        }
        $tagRepository = $em->getRepository("AGILDefaultBundle:AgilTag");

        $subject = new AgilForumSubject($user,$category,null,null);
        $subject->setTags(array());
        $firstPost = new AgilForumAnswer(null, $user, null);
        $firstPost->setSubject($subject);

        $form = $this->createForm(new FirstAnswerType(), $firstPost);

        $form->handleRequest($request);
        if ($form->isValid()) {

            // On récupère les tags qui ont été tapés, on en fait un tableau
            $tagsArrayString = explode(" ", $subject->getTags());
            $subject->setTags(null);

            foreach($tagsArrayString as $tag){

                $t = $tagRepository->findOneBy(array('tagName' => $tag));
                if($t == null){
                    $t = new AgilTag($tag,'tag-default',null);
                    $em->persist($t);
                }
                $subject->addTag($t);

            }

            // On remet les tags sous forme de tableau de AgilTag
            //$subject->setTags($tagRepository->findByTagName($tagsArrayString));

            $em->persist($firstPost);
            $em->persist($subject);
            $em->flush($subject);
            $em->flush($firstPost);

            $this->addFlash('success', "Le sujet a bien été créé");
            return $this->redirect( $this->generateUrl('agil_forum_subject_answers', array(
                'idCategory' => $idCategory,
                'idSubject' => $subject->getForumSubjectId()
            )));
        }

        return $this->render('AGILForumBundle:Subjects:subjects_add.html.twig', array(
            'form' => $form->createView(),
            'idCategory' => $idCategory
        ));
    }

    /**
     * Suppression de sujet
     * @param $idCategory
     * @param $idSubject
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function subjectDeleteAction($idCategory, $idSubject, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $subject = $em->getRepository("AGILForumBundle:AgilForumSubject")->find($idSubject);
        $category = $em->getRepository("AGILForumBundle:AgilForumCategory")->find($idCategory);
        if ($category === null or $subject === null or $subject->getCategory() != $category) {
            if ($category === null) {
                $this->addFlash('warning', "La catégorie d'id " . $idCategory . " n'existe pas.");
                return $this->redirect( $this->generateUrl('agil_forum_homepage'));
            } elseif ($subject === null) {
                $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'existe pas.");
            } elseif ($subject->getCategory() != $category) {
                $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'appartient pas à la catégorie d'id ".$idCategory);
            }

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list',
                array('idCategory' => $idCategory)) );
        }

        $author = $subject->getUser();
        $title = $subject->getForumSubjectTitle();

        if (!$user->hasRole('ROLE_MODERATOR') and !$user->hasRole('ROLE_ADMIN') and !$user->hasRole('ROLE_SUPER_ADMIN')
            and $author != $user) {
            $this->addFlash('warning', 'Permission refusée : vous n\'êtes pas l\'auteur du sujet');

            return $this->redirect( $this->generateUrl('agil_forum_subjects_list',
                array('idCategory' => $idCategory)) );
        }

        $isAdmin = false;
        if ($author != $user and ($user->hasRole('ROLE_MODERATOR') or $user->hasRole('ROLE_ADMIN') or
                $user->hasRole('ROLE_SUPER_ADMIN'))) {
            $form = $this->createForm(new DeleteSubjectAdminType(), null);
            $isAdmin = true;
        } else {
            $form = $this->createForm(new DeleteSubjectType(), null);
        }

        $form->handleRequest($request);
        if ($form->isValid()) {

            if ($isAdmin) {
                $reason = $form->get('reason')->getData();
                $subjectMail = "Amicale GIL[Suppression d'un sujet du forum]";
                $message = '<p>Bonjour '.$author->getUsername().',</p>';
                $message .= '<p>votre sujet "'.$title.'" a été supprimé du forum.</p>';
                $message .= "<p>Raison de la suppression :</p>";
                $message .= '<p>"'.$reason.'"</p>';
                $message .= "<p>Cordialement</p>";

                $this->sendMail($subjectMail, $message, $author->getEmail());
            }

            $em->remove($subject);
            $em->flush();

            $this->addFlash('success', "Le sujet a bien été supprimé.");
            return $this->redirect( $this->generateUrl('agil_forum_subjects_list', array(
                'idCategory' => $idCategory
            )));
        }

        return $this->render('AGILForumBundle:Subjects:subjects_delete.html.twig', array(
            'form' => $form->createView(),
            'subject' => $subject,
            'idCategory' => $idCategory,
            'idSubject' => $idSubject,
            'isAdmin' => $isAdmin
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
            $this->addFlash('warning', "La catégorie d'id " . $idCategory . " n'existe pas.");
            return $this->redirectToRoute('agil_forum_homepage');
        }

        // Récupération de l'objet Subject par rapport à l'ID spécifié dans l'URL
        $subject = $subjectRepository->find($idSubject);
        if ($subject === null) {
            $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'existe pas.");
            return $this->redirectToRoute('agil_forum_subjects_list', array('idCategory' => $idCategory));
        }

        // On vérifie que le Subject appartient bien à cette Category
        if ($subject->getCategory() != $category) {
            $this->addFlash('warning', "Le sujet d'id ".$idSubject." n'appartient pas à la catégorie d'id ".$idCategory);
            return $this->redirectToRoute('agil_forum_subjects_list', array('idCategory' => $idCategory));
        }

        // Si le sujet n'est pas déjà Résolu
        if(!$subject->getForumSubjectIsResolved()){

            // Si le sujet appartient bien à la personne connecté
            if($subject->getUser() == $this->get('security.context')->getToken()->getUser()){

                $subject->setForumSubjectIsResolved(true);

                // Modification du sujet dans la BDD
                $manager->persist($subject);
                $manager->flush();

            }else{
                $this->addFlash('warning', "Vous essayez passer en résolu un sujet de forum qui n'est pas le votre");
            }

        }else{
            $this->addFlash('warning', "Le sujet de forum est déjà résolu");
        }

        return $this->redirectToRoute('agil_forum_subject_answers', array('idCategory' => $idCategory, 'idSubject' => $idSubject));

    }

    /**
     * fonction d'envoie de mail
     * @param $subject
     * @param $body
     * @param $to
     */
    function sendMail($subject, $body, $to) {
        $headers = 'From: amicale.gil@etu.univ-rouen.fr' . "\r\n";
        $headers .= "Reply-To: amicale.gil@etu.univ-rouen.fr\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"";

        $message = "
        <html>
            <head></head>
            <body>
                $body
            </body>
        </html>";

        if(mail($to, $subject, $message, $headers))
        {
            $this->addFlash('success', 'Mail envoyé !');
        }
        else
        {
            $this->addFlash('warning', 'Erreur lors de l\'envoie de l\'email.');
        }
    }
    /**
     * Permet d'insérer un tag dans la BDD
     *
     * @param $tagName
     * @param string $color
     * @param AgilSkill|null $skillCat
     * @throws InvalidArgumentException
     */
    function insertTag($tagName, $color = '', AgilSkill $skillCat = null) {
        if (!$tagName) {
            throw new InvalidArgumentException('Un tag doit posséder au moins une lettre');
        }

        if (null === $this->findOneByTagName($tagName)) {
            $tag = new AgilTag($tagName, '', null);
            $tag->setSkillCategory((null == $skillCat)? null : $skillCat);
            $tag->setTagColor(($color)? $color : '');

            $this->getEntityManager()->persist($tag);
            $this->getEntityManager()->flush();
        }
    }
}
