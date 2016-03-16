<?php

namespace AGIL\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AGIL\SearchBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    private $forumSubjectRepository;
    private $tagRepository;


    public function searchAction(Request $request)
    {
        $this->tagRepository = $this->getDoctrine()->getManager()->getRepository('AGILDefaultBundle:AgilTag');
        $this->forumSubjectRepository = $this->getDoctrine()->getManager()->getRepository('AGILForumBundle:AgilForumSubject');

        $formFilter = $request->query->get('filter');
        $formMethod = $request->query->get('method');
        $formTags = $request->query->get('tags');


        if($formFilter != null){

            $tagArray = preg_split("/[\\s,]+/", $formTags);
            $tagArray = array_unique($tagArray);
            $tagArray = preg_grep("/^[a-zA-Z0-9]+$/", $tagArray);


            if($formFilter == "all"){

                if($formMethod != null){

                    // ----------- METHOD AND / OR -----------
                    if($formMethod == "and" || $formMethod == "or"){


                        // Recherche Forum
                        $searchForumLast = $this->searchForumSubjectAll($tagArray,$formMethod);
                        $tagsForumLast = $this->tagsForForumSubject($searchForumLast);

                        // Autres recherches ...

                        return $this->render('AGILSearchBundle:Default:index.html.twig',
                            array('searchForumLast' => $searchForumLast, 'tagsForumLast' => $tagsForumLast)
                        );

                    }

                }

            }

        }

        return $this->render('AGILSearchBundle:Default:index.html.twig');
    }

    /**
     * Code de test (formulaire header)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testAction()
    {
        $form = $this->createForm(new SearchType(), array(), array(
            'action' => $this->generateUrl('agil_search_homepage'),
            'method' => 'GET',
            'csrf_protection' => false
        ));

        return $this->render('AGILSearchBundle:Default:test.html.twig',array('form' => $form->createView()));
    }


    /**
     * Recherche de sujets de forum par rapport à des tags
     *
     * @param $tagArray
     * @param $method
     * @return null
     */
    private function searchForumSubjectAll($tagArray,$method){

        if($method == "and"){
            return $this->tagRepository->getAndSubjectByTags($tagArray);
        }else if ($method == "or"){
            return $this->tagRepository->getOrSubjectByTags($tagArray);
        }else{
            return null;
        }

    }

    /**
     * Retourne les tags pour chaque sujets de forum trouvés
     *
     * @param $searchForumLast
     * @return array
     */
    private function tagsForForumSubject($searchForumLast){
        $tagsForumLast[] = null;
        foreach($searchForumLast as $sub){
            $subject = $this->forumSubjectRepository->find($sub['forumSubjectId']);
            $tagsForumLast[$sub['forumSubjectId']] = $subject->getTags();
        }
        return $tagsForumLast;
    }

}
