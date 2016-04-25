<?php

namespace AGIL\ChatBundle\Controller;

use AGIL\ChatBundle\Entity\AgilChatTable;
use AGIL\ChatBundle\Form\ChatTableType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $chatTable = new AgilChatTable();


        $manager = $this->getDoctrine()->getManager();
        $chatTableRepository = $manager->getRepository('AGILChatBundle:AgilChatTable');
        $chatTableList = $chatTableRepository->findAll();

        $form = $this->createForm(new ChatTableType(), $chatTable, array('attr'=>array('autocomplete'=>'off')));
        $form->handleRequest($request);

        if ($form->isValid()) {

            $chatTableTest = $chatTableRepository->findBy(array('chatTableName' => $form->get('chatTableName')->getData()));
            if($chatTableTest != null){
                $this->addFlash('warning', 'Le nom de Table est déjà utilisé');
            }else{
                $chatTable->setUser($user);
                $em->persist($chatTable);
                $em->flush();

                $this->addFlash('success', "La table a bien été créé");
            }
            return $this->redirect($this->generateUrl('agil_chat_homepage'));

        }

        return $this->render('AGILChatBundle:Default:index.html.twig',
            array('chatTableList' => $chatTableList, 'form' => $form->createView()));
    }

    public function chatLiveAction($roomId)
    {
        $manager = $this->getDoctrine()->getManager();
        $chatTableRepository = $manager->getRepository('AGILChatBundle:AgilChatTable');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $table= $chatTableRepository ->find($roomId);

        if($table!=null){
            $user =$this->getUser();
            return $this->render('AGILChatBundle:Default:chatLive.html.twig', array('chatTable'=>$table,'user'=>$user));
        }else{
            $this->addFlash('warning', "La table id " . $roomId. " n'existe pas .");
            return $this->redirectToRoute('agil_chat_homepage');
        }


    }

    /**
     *  Requête pour l'ajax pour récupérer les données d'un utilisateurs
     * @param Request $req
     * @return Response
     */
    public function getUserByIdAction(Request $req){
        if ($req->isXMLHttpRequest()) {
            $idUser = $req->get('id_user');

            $em = $this->getDoctrine()->getManager();
            $user  = $em->getRepository('AGILUserBundle:AgilUser')->find($idUser);
            $user_final = array('userName'=>$user->getUserName(), 'userId'=>$user->getUserId(), 'profilPicture'=>$user->getUserProfilePictureUrl());

                return new Response(json_encode($user_final));
        }
        return new Response("erreur...");
    }
}
