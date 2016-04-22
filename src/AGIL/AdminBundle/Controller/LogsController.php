<?php

namespace AGIL\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class LogsController extends Controller
{
    /**
     * Affichage des logs du Forum
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function forumAction(Request $request)
    {
        $pathLogFile = $this->get('kernel')->getLogDir().'/logsForum.log';

        // Suppression du fichier
        if($request->isMethod('POST')){
            if (file_exists($pathLogFile)) {
                unlink($pathLogFile);
                $this->addFlash('success', "Le fichier de log est maintenant réinitialisé");
            }else{
                $this->addFlash('warning', "Le fichier de log est déjà réinitialisé");
            }
        }

        if (file_exists($pathLogFile)) {
            $contentLogFile = file_get_contents($pathLogFile, true);
        }else{
            $contentLogFile = "Fichier vide";
        }

        return $this->render('AGILAdminBundle:Logs:logs_forum.html.twig',array('logsForum' => $contentLogFile));
    }


    /**
     * Affichage des logs de la Recherche
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $pathLogFile = $this->get('kernel')->getLogDir().'/logsSearch.log';

        // Suppression du fichier
        if($request->isMethod('POST')){
            if (file_exists($pathLogFile)) {
                unlink($pathLogFile);
                $this->addFlash('success', "Le fichier de log est maintenant réinitialisé");
            }else{
                $this->addFlash('warning', "Le fichier de log est déjà réinitialisé");
            }
        }

        if (file_exists($pathLogFile)) {
            $contentLogFile = file_get_contents($pathLogFile, true);
        }else{
            $contentLogFile = "Fichier vide";
        }

        return $this->render('AGILAdminBundle:Logs:logs_search.html.twig',array('logsSearch' => $contentLogFile));
    }


    /**
     * Affichage des logs des Offres
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function offerAction(Request $request)
    {
        $pathLogFile = $this->get('kernel')->getLogDir().'/logsOffer.log';

        // Suppression du fichier
        if($request->isMethod('POST')){
            if (file_exists($pathLogFile)) {
                unlink($pathLogFile);
                $this->addFlash('success', "Le fichier de log est maintenant réinitialisé");
            }else{
                $this->addFlash('warning', "Le fichier de log est déjà réinitialisé");
            }
        }

        if (file_exists($pathLogFile)) {
            $contentLogFile = file_get_contents($pathLogFile, true);
        }else{
            $contentLogFile = "Fichier vide";
        }

        return $this->render('AGILAdminBundle:Logs:logs_offer.html.twig',array('logsOffer' => $contentLogFile));
    }


    /**
     * Affichage des logs des Profils
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request)
    {
        $pathLogFile = $this->get('kernel')->getLogDir().'/logsProfile.log';

        // Suppression du fichier
        if($request->isMethod('POST')){
            if (file_exists($pathLogFile)) {
                unlink($pathLogFile);
                $this->addFlash('success', "Le fichier de log est maintenant réinitialisé");
            }else{
                $this->addFlash('warning', "Le fichier de log est déjà réinitialisé");
            }
        }

        if (file_exists($pathLogFile)) {
            $contentLogFile = file_get_contents($pathLogFile, true);
        }else{
            $contentLogFile = "Fichier vide";
        }

        return $this->render('AGILAdminBundle:Logs:logs_profile.html.twig',array('logsProfile' => $contentLogFile));
    }


    /**
     * Affichage des logs du Chat
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function chatAction(Request $request)
    {
        $pathLogFile = $this->get('kernel')->getLogDir().'/logsChat.log';

        // Suppression du fichier
        if($request->isMethod('POST')){
            if (file_exists($pathLogFile)) {
                unlink($pathLogFile);
                $this->addFlash('success', "Le fichier de log est maintenant réinitialisé");
            }else{
                $this->addFlash('warning', "Le fichier de log est déjà réinitialisé");
            }
        }

        if (file_exists($pathLogFile)) {
            $contentLogFile = file_get_contents($pathLogFile, true);
        }else{
            $contentLogFile = "Fichier vide";
        }

        return $this->render('AGILAdminBundle:Logs:logs_chat.html.twig',array('logsChat' => $contentLogFile));
    }


    /**
     * Affichage des logs du Hall
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function hallAction(Request $request)
    {
        $pathLogFile = $this->get('kernel')->getLogDir().'/logsHall.log';

        // Suppression du fichier
        if($request->isMethod('POST')){
            if (file_exists($pathLogFile)) {
                unlink($pathLogFile);
                $this->addFlash('success', "Le fichier de log est maintenant réinitialisé");
            }else{
                $this->addFlash('warning', "Le fichier de log est déjà réinitialisé");
            }
        }

        if (file_exists($pathLogFile)) {
            $contentLogFile = file_get_contents($pathLogFile, true);
        }else{
            $contentLogFile = "Fichier vide";
        }

        return $this->render('AGILAdminBundle:Logs:logs_hall.html.twig',array('logsHall' => $contentLogFile));
    }


}
