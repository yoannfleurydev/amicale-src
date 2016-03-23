<?php

namespace AGIL\SearchBundle\Controller;

use AGIL\SearchBundle\Form\SearchAdvancedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AGIL\SearchBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    private $forumSubjectRepository;
    private $hallEventRepository;
    private $offerRepository;
    private $tagRepository;


    public function searchAction(Request $request)
    {
        $this->tagRepository = $this->getDoctrine()->getManager()->getRepository('AGILDefaultBundle:AgilTag');
        $this->forumSubjectRepository = $this->getDoctrine()->getManager()->getRepository('AGILForumBundle:AgilForumSubject');
        $this->hallEventRepository = $this->getDoctrine()->getManager()->getRepository('AGILHallBundle:AgilEvent');
        $this->offerRepository = $this->getDoctrine()->getManager()->getRepository('AGILOfferBundle:AgilOffer');

        $formFilter = $request->query->get('filter');
        $formMethod = $request->query->get('method');
        $formTags = $request->query->get('tags');

        $form = $this->createForm(new SearchAdvancedType(), array(), array(
            'action' => $this->generateUrl('agil_search_homepage'),
            'method' => 'GET',
            'csrf_protection' => false
        ));

        if($formFilter != null){

            $tagArray = preg_split("/[\\s,]+/", $formTags);
            $tagArray = array_unique($tagArray);
            $tagArray = preg_grep("/^[a-zA-Z0-9]+$/", $tagArray);


            if($formFilter == "all"){

                if($formMethod != null){

                    // ----------- METHOD AND / OR -----------
                    if($formMethod == "and" || $formMethod == "or"){


                        // Recherche Forum (Sujets)
                        $searchForumLast = $this->searchForumSubjectAll($tagArray,$formMethod);
                        $tagsForumLast = $this->tagsForForumSubject($searchForumLast);

                        // Recherche Hall (Evènements)
                        $searchHall = $this->searchHall($tagArray,$formMethod);
                        $tagsHall = $this->tagsForHallEvent($searchHall);

                        // Recherche Offres (Annonces)
                        $searchOffers = $this->searchOffers($tagArray,$formMethod);
                        $tagsOffers = $this->tagsForOffers($searchOffers);

                        // Autres recherches ...

                        return $this->render('AGILSearchBundle:Default:index.html.twig',
                            array('searchForumLast' => $searchForumLast, 'tagsForumLast' => $tagsForumLast,
                                'searchHall' => $searchHall, 'tagsHall' => $tagsHall, 'form' => $form->createView(),
                                'searchOffers' => $searchOffers, 'tagsOffers' => $tagsOffers)
                        );

                    }

                }

            }

        }

        return $this->render('AGILSearchBundle:Default:index.html.twig',array(
            'form' => $form->createView()
        ));
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


    /**
     * Recherche d'evènements du hall par rapport à des tags
     *
     * @param $tagArray
     * @param $method
     * @return null
     */
    private function searchHall($tagArray,$method){

        if($method == "and"){
            return $this->tagRepository->getAndEventByTags($tagArray);
        }else if ($method == "or"){
            return $this->tagRepository->getOrEventByTags($tagArray);
        }else{
            return null;
        }

    }

    /**
     * Retourne les tags pour chaque évènements du hall trouvés
     *
     * @param $searchHall
     * @return array
     */
    private function tagsForHallEvent($searchHall){
        $tagsHall[] = null;
        foreach($searchHall as $event){
            $ev = $this->hallEventRepository->find($event['eventId']);
            $tagsHall[$event['eventId']] = $ev->getTags();
        }
        return $tagsHall;
    }


    /**
     * Recherche d'offres par rapport à des tags
     *
     * @param $tagArray
     * @param $method
     * @return null
     */
    private function searchOffers($tagArray,$method){

        if($method == "and"){
            return $this->tagRepository->getAndOfferByTags($tagArray);
        }else if ($method == "or"){
            return $this->tagRepository->getOrOfferByTags($tagArray);
        }else{
            return null;
        }

    }

    /**
     * Retourne les tags pour chaque offres trouvées
     *
     * @param $searchOffers
     * @return array
     */
    private function tagsForOffers($searchOffers){
        $tagsOffer[] = null;
        foreach($searchOffers as $offer){
            $off = $this->offerRepository->find($offer['offerId']);
            $tagsOffer[$offer['offerId']] = $off->getTags();
        }
        return $tagsOffer;
    }



}
