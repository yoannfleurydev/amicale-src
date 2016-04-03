<?php

namespace AGIL\SearchBundle\Controller;

use AGIL\SearchBundle\Form\SearchAdvancedType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AGIL\SearchBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DefaultController extends Controller
{

    private $forumSubjectRepository;
    private $hallEventRepository;
    private $offerRepository;
    private $tagRepository;
    private $skillRepository;


    public function searchAction(Request $request)
    {
        $this->tagRepository = $this->getDoctrine()->getManager()->getRepository('AGILDefaultBundle:AgilTag');
        $this->forumSubjectRepository = $this->getDoctrine()->getManager()->getRepository('AGILForumBundle:AgilForumSubject');
        $this->hallEventRepository = $this->getDoctrine()->getManager()->getRepository('AGILHallBundle:AgilEvent');
        $this->offerRepository = $this->getDoctrine()->getManager()->getRepository('AGILOfferBundle:AgilOffer');
        $this->skillRepository = $this->getDoctrine()->getManager()->getRepository('AGILProfileBundle:AgilSkill');

        $formFilter = $request->query->get('filter');
        $formMethod = $request->query->get('method');
        $formTags   = $request->query->get('tags');
        $formNo     = $request->query->get('no');
        $page       = $request->query->get('p');

        // Les valeurs par défaut
        if($page == null)
            $page = 1;
        if($formMethod == null)
            $formMethod = "and";
        if($formFilter == null)
            $formFilter = "all";

        $form = $this->createForm(new SearchAdvancedType(),
            array(
            'tags' => $formTags,
            'method' => $formMethod,
            'filter' => $formFilter,
            'no' => $formNo),
            array(
            'action' => $this->generateUrl('agil_search_homepage'),
            'method' => 'GET',
            'csrf_protection' => false
        ));

        if($formFilter != null && $formTags != null){

            // Méthode de recherche qui contient un peu de tout
            if($formFilter == "all"){

                if($formMethod == "and" || $formMethod == "or"){

                    // Recherche Forum (Sujets)
                    $searchForum    = $this->searchForumSubject($formTags,$formNo,$formMethod);
                    $tagsForum      = $this->tagsForForumSubject($searchForum[0]);

                    // Recherche Hall (Evènements)
                    $searchHall     = $this->searchHall($formTags,$formNo,$formMethod);
                    $tagsHall       = $this->tagsForHallEvent($searchHall[0]);

                    // Recherche Offres (Annonces)
                    $searchOffers   = $this->searchOffers($formTags,$formNo,$formMethod);
                    $tagsOffers     = $this->tagsForOffers($searchOffers[0]);

                    // Recherche Profils (User)
                    $searchProfile  = $this->searchProfiles($formTags,$formNo,$formMethod);
                    $tagsProfile    = $this->tagsForProfiles($searchProfile[0]);

                    return $this->render('AGILSearchBundle:Default:index.html.twig',
                        array('searchForum' => $searchForum, 'tagsForum' => $tagsForum,
                            'searchHall' => $searchHall, 'tagsHall' => $tagsHall, 'form' => $form->createView(),
                            'searchOffers' => $searchOffers, 'tagsOffers' => $tagsOffers,
                            'searchProfile' => $searchProfile, 'tagsProfile' => $tagsProfile)
                    );

                }

            } // Méthode de recherche individuelle
            else if ($formFilter == "forum" || $formFilter == "offer"
                || $formFilter == "hall" || $formFilter == "profile"){

                if($formMethod == "and" || $formMethod == "or"){

                    $maxPerPage = 10;
                    $route = 'agil_search_homepage';
                    $route_params = array('tags' => $formTags,
                        'method' => $formMethod,
                        'filter' => $formFilter);

                    if($page <= 0)
                        throw new NotFoundHttpException("Erreur dans le numéro de page");


                    // ---------------------- RECHERCHE FORUM ----------------------
                    if($formFilter == "forum"){

                        $searchForum = $this->searchForumSubject($formTags,$formNo,$formMethod,$page,$maxPerPage);
                        $tagsForum = $this->tagsForForumSubject($searchForum[0]);
                        $countTotal = $searchForum[1];

                        if($page > ceil($countTotal / $maxPerPage) && $countTotal != 0)
                            throw new NotFoundHttpException("Erreur dans le numéro de page");

                        $pagination = array(
                            'page' => $page,
                            'route' => $route,
                            'pages_count' => ceil($countTotal / $maxPerPage),
                            'route_params' => $route_params
                        );

                        return $this->render('AGILSearchBundle:Default:index.html.twig',
                            array('searchForum' => $searchForum, 'tagsForum' => $tagsForum,
                                'form' => $form->createView(), 'pagination' => $pagination)
                        );

                    }
                    // ---------------------- RECHERCHE HALL ----------------------
                    if($formFilter == "hall"){

                        $searchHall = $this->searchHall($formTags,$formNo,$formMethod,$page,$maxPerPage);
                        $tagsHall = $this->tagsForHallEvent($searchHall[0]);
                        $countTotal = $searchHall[1];

                        if($page > ceil($countTotal / $maxPerPage) && $countTotal != 0)
                            throw new NotFoundHttpException("Erreur dans le numéro de page");

                        $pagination = array(
                            'page' => $page,
                            'route' => $route,
                            'pages_count' => ceil($countTotal / $maxPerPage),
                            'route_params' => $route_params
                        );

                        return $this->render('AGILSearchBundle:Default:index.html.twig',
                            array('searchHall' => $searchHall, 'tagsHall' => $tagsHall,
                                'form' => $form->createView(), 'pagination' => $pagination)
                        );

                    }
                    // ---------------------- RECHERCHE OFFRES ----------------------
                    if($formFilter == "offer"){

                        $searchOffers = $this->searchOffers($formTags,$formNo,$formMethod,$page,$maxPerPage);
                        $tagsOffers = $this->tagsForOffers($searchOffers[0]);
                        $countTotal = $searchOffers[1];

                        if($page > ceil($countTotal / $maxPerPage) && $countTotal != 0)
                            throw new NotFoundHttpException("Erreur dans le numéro de page");

                        $pagination = array(
                            'page' => $page,
                            'route' => $route,
                            'pages_count' => ceil($countTotal / $maxPerPage),
                            'route_params' => $route_params
                        );

                        return $this->render('AGILSearchBundle:Default:index.html.twig',
                            array('searchOffers' => $searchOffers, 'tagsOffers' => $tagsOffers,
                                'form' => $form->createView(), 'pagination' => $pagination)
                        );

                    }
                    // ---------------------- RECHERCHE PROFILS ----------------------
                    if($formFilter == "profile"){

                        $searchProfile = $this->searchProfiles($formTags,$formNo,$formMethod,$page,$maxPerPage);
                        $tagsProfile = $this->tagsForProfiles($searchProfile[0]);
                        $countTotal = $searchProfile[1];

                        if($page > ceil($countTotal / $maxPerPage) && $countTotal != 0)
                            throw new NotFoundHttpException("Erreur dans le numéro de page");

                        $pagination = array(
                            'page' => $page,
                            'route' => $route,
                            'pages_count' => ceil($countTotal / $maxPerPage),
                            'route_params' => $route_params
                        );

                        return $this->render('AGILSearchBundle:Default:index.html.twig',
                            array('searchProfile' => $searchProfile, 'tagsProfile' => $tagsProfile,
                                'form' => $form->createView(), 'pagination' => $pagination)
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
     * @param int $page
     * @param int $maxPerPage
     * @return null
     */
    private function searchForumSubject($tagArray,$tagNo,$method,$page=1,$maxPerPage=4){

        if($method == "and"){
            return $this->tagRepository->getAndSubjectByTags($tagArray,$tagNo,$page,$maxPerPage);
        }else if ($method == "or"){
            return $this->tagRepository->getOrSubjectByTags($tagArray,$tagNo,$page,$maxPerPage);
        }else{
            return null;
        }

    }

    /**
     * Retourne les tags pour chaque sujets de forum trouvés
     *
     * @param $searchForum
     * @return array
     */
    private function tagsForForumSubject($searchForum){
        $tagsForum[] = null;
        foreach($searchForum as $sub){
            $subject = $this->forumSubjectRepository->find($sub['forumSubjectId']);
            $tagsForum[$sub['forumSubjectId']] = $subject->getTags();
        }
        return $tagsForum;
    }


    /**
     * Recherche d'evènements du hall par rapport à des tags
     *
     * @param $tagArray
     * @param $method
     * @param int $page
     * @param int $maxPerPage
     * @return null
     */
    private function searchHall($tagArray,$tagNo,$method,$page=1,$maxPerPage=4){

        if($method == "and"){
            return $this->tagRepository->getAndEventByTags($tagArray,$tagNo,$page,$maxPerPage);
        }else if ($method == "or"){
            return $this->tagRepository->getOrEventByTags($tagArray,$tagNo,$page,$maxPerPage);
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
     * @param int $page
     * @param int $maxPerPage
     * @return null
     */
    private function searchOffers($tagArray,$tagNo,$method,$page=1,$maxPerPage=4){

        if($method == "and"){
            return $this->tagRepository->getAndOfferByTags($tagArray,$tagNo,$page,$maxPerPage);
        }else if ($method == "or"){
            return $this->tagRepository->getOrOfferByTags($tagArray,$tagNo,$page,$maxPerPage);
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

    /**
     * Recherche de profils par rapport à des tags
     *
     * @param $tagArray
     * @param $method
     * @param int $page
     * @param int $maxPerPage
     * @return null
     */
    private function searchProfiles($tagArray,$tagNo,$method,$page=1,$maxPerPage=4){

        if($method == "and"){
            return $this->tagRepository->getAndProfileByTags($tagArray,$tagNo,$page,$maxPerPage);
        }else if ($method == "or"){
            return $this->tagRepository->getOrProfileByTags($tagArray,$tagNo,$page,$maxPerPage);
        }else{
            return null;
        }

    }


    /**
     * Recherche des 5 meilleurs tags pour les users recherché
     *
     * @param $searchProfile
     * @return null
     */
    private function tagsForProfiles($searchProfile){
        $tagsProfile = null;
        foreach($searchProfile as $user){
            $tagsProfile[$user->getId()] = $this->skillRepository->findBy(array('user' => $user->getId()),array('skillLevel' => 'desc'),5);
        }
        return $tagsProfile;
    }

}
