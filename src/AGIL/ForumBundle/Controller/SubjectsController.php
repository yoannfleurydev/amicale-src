<?php

namespace AGIL\ForumBundle\Controller;

use AGIL\DefaultBundle\Entity\AgilTag;
use AGIL\ForumBundle\Entity\AgilForumAnswer;
use AGIL\ForumBundle\Form\AnswerType;
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

            return $this->redirect( $this->generateUrl('agil_forum_subject_answers', array('idCategory' => $idCategory, 'idSubject' => $subject->getForumSubjectId())) );
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

        $form = $this->createForm(new DeleteSubjectType(), null);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->remove($subject);
            $em->flush();

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
