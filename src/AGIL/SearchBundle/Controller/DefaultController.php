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


    /**
     * Code qui sera à insérer dans tous les contrôleurs du site !!
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testAction()
    {
        // Ajouter cette ligne dans tous les contrôleurs du site
        $formSearchBar = $this->createForm(new SearchType());

        // Ajouter 'formSearchBar' => $formSearchBar->createView() dans l'array de retour du render
        return $this->render('AGILSearchBundle:Default:test.html.twig',array('formSearchBar' => $formSearchBar->createView()));
    }




    /**
     * Contrôleur du formulaire avancé de recherche
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        // Formulaire barre de recherche (header)
        $formSearchBar = $this->createForm(new SearchType());

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

            // Méthode de recherche qui de tout (4/type au maximum)
            if($formFilter == "all"){

                if($formMethod == "and" || $formMethod == "or"){

                    $logger = $this->get('service_search.logger');
                    $logger->info("[Filtre : tout - Méthode : ".$formMethod."] Saisie : ".$formTags." - Non : ".$formNo);

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
                            'searchHall' => $searchHall, 'tagsHall' => $tagsHall,
                            'searchOffers' => $searchOffers, 'tagsOffers' => $tagsOffers,
                            'searchProfile' => $searchProfile, 'tagsProfile' => $tagsProfile,
                            'form' => $form->createView(),'formSearchBar' => $formSearchBar->createView())
                    );

                }

            } // Méthode de recherche individuelle
            else if ($formFilter == "forum" || $formFilter == "offer"
                || $formFilter == "hall" || $formFilter == "profile"){

                if($formMethod == "and" || $formMethod == "or"){

                    // Paramètres de pagination
                    $maxPerPage = 10;
                    $route = 'agil_search_homepage';
                    $route_params = array('tags' => $formTags,
                        'method' => $formMethod,
                        'filter' => $formFilter);

                    if($page <= 0)
                        throw new NotFoundHttpException("Erreur dans le numéro de page");


                    $logger = $this->get('service_search.logger');
                    $logger->info("[Filtre : ".$formFilter." - Méthode : ".$formMethod."] Saisie : ".$formTags." - Non : ".$formNo);


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
                                'form' => $form->createView(), 'pagination' => $pagination,
                                'formSearchBar' => $formSearchBar->createView())
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
                                'form' => $form->createView(), 'pagination' => $pagination,
                                'formSearchBar' => $formSearchBar->createView())
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
                                'form' => $form->createView(), 'pagination' => $pagination,
                                'formSearchBar' => $formSearchBar->createView())
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
                                'form' => $form->createView(), 'pagination' => $pagination,
                                'formSearchBar' => $formSearchBar->createView())
                        );

                    }

                }

            }

        }

        return $this->render('AGILSearchBundle:Default:index.html.twig',array(
            'form' => $form->createView(), 'formSearchBar' => $formSearchBar->createView()
        ));
    }

    /**
     * Recherche de sujets de forum
     *
     * @param $formTags
     * @param $formNo
     * @param $method
     * @param int $page
     * @param int $maxPerPage
     * @return null
     */
    private function searchForumSubject($formTags,$formNo,$method,$page=1,$maxPerPage=4){

        if($method == "and"){
            return $this->tagRepository->getAndSubject($formTags,$formNo,$page,$maxPerPage);
        }else if ($method == "or"){
            return $this->tagRepository->getOrSubject($formTags,$formNo,$page,$maxPerPage);
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
     * Recherche d'evènements du hall
     *
     * @param $formTags
     * @param $formNo
     * @param $method
     * @param int $page
     * @param int $maxPerPage
     * @return null
     */
    private function searchHall($formTags,$formNo,$method,$page=1,$maxPerPage=4){

        if($method == "and"){
            return $this->tagRepository->getAndEvent($formTags,$formNo,$page,$maxPerPage);
        }else if ($method == "or"){
            return $this->tagRepository->getOrEvent($formTags,$formNo,$page,$maxPerPage);
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
     * Recherche d'offres
     *
     * @param $formTags
     * @param $formNo
     * @param $method
     * @param int $page
     * @param int $maxPerPage
     * @return null
     */
    private function searchOffers($formTags,$formNo,$method,$page=1,$maxPerPage=4){

        if($method == "and"){
            return $this->tagRepository->getAndOffer($formTags,$formNo,$page,$maxPerPage);
        }else if ($method == "or"){
            return $this->tagRepository->getOrOffer($formTags,$formNo,$page,$maxPerPage);
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
     * Recherche de profils
     *
     * @param $formTags
     * @param $formNo
     * @param $method
     * @param int $page
     * @param int $maxPerPage
     * @return null
     */
    private function searchProfiles($formTags,$formNo,$method,$page=1,$maxPerPage=4){

        if($method == "and"){
            return $this->tagRepository->getAndProfile($formTags,$formNo,$page,$maxPerPage);
        }else if ($method == "or"){
            return $this->tagRepository->getOrProfile($formTags,$formNo,$page,$maxPerPage);
        }else{
            return null;
        }

    }


    /**
     * Recherche des 5 meilleurs tags pour les users recherchés
     *
     * @param $searchProfile
     * @return null
     */
    private function tagsForProfiles($searchProfile){
        $tagsProfile = null;
        if($searchProfile != null){
            foreach($searchProfile as $user){
                $tagsProfile[$user->getId()] = $this->skillRepository->findBy(array('user' => $user->getId()),array('skillLevel' => 'desc'),5);
            }
        }
        return $tagsProfile;
    }

}
