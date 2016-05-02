<?php

namespace AGIL\ChatBundle\Controller;

use AGIL\ChatBundle\Entity\AgilChatMessage;
use AGIL\ChatBundle\Entity\AgilChatTable;
use AGIL\ChatBundle\Form\ChatTableType;
use AGIL\SearchBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $formSearchBar = $this->createForm(new SearchType());

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $chatTable = new AgilChatTable();


        $manager = $this->getDoctrine()->getManager();
        $chatTableRepository = $manager->getRepository('AGILChatBundle:AgilChatTable');
        $chatTableList = $chatTableRepository->findAll();

        $form = $this->createForm(new ChatTableType(), $chatTable, array('attr' => array('autocomplete' => 'off')));
        $form->handleRequest($request);

        if ($form->isValid()) {

            $chatTableTest = $chatTableRepository->findBy(array('chatTableName' => $form->get('chatTableName')->getData()));
            if ($chatTableTest != null) {
                $this->addFlash('warning', 'Le nom de Table est déjà utilisé');
            } else {
                $chatTable->setUser($user);
                $em->persist($chatTable);
                $em->flush();

                $this->addFlash('success', "La table a bien été créé");
            }
            return $this->redirect($this->generateUrl('agil_chat_homepage'));

        }

        return $this->render('AGILChatBundle:Default:index.html.twig',
            array(
                'chatTableList' => $chatTableList,
                'formSearchBar' => $formSearchBar->createView(),
                'form' => $form->createView()));
    }

    public function chatLiveAction($roomId)
    {
        $manager = $this->getDoctrine()->getManager();
        $chatTableRepository = $manager->getRepository('AGILChatBundle:AgilChatTable');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $table= $chatTableRepository ->find($roomId);
        $messages = $manager->getRepository('AGILChatBundle:AgilChatMessage')->findBy(
            array('table' => $table),
            array('chatMessageDate' => 'ASC'),
            100
        );

        if($table!=null){
            $user =$this->getUser();
            return $this->render('AGILChatBundle:Default:chatLive.html.twig', array('chatTable'=>$table,'user'=>$user,'messages' => $messages, 'lastMessages' => null));
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
    public function getUserByIdAction(Request $req)
    {
        if ($req->isXMLHttpRequest()) {
            $idUser = $req->get('id_user');

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AGILUserBundle:AgilUser')->find($idUser);
            $user_final = array('userName' => $user->getUserName(), 'userId' => $user->getUserId(), 'profilPicture' => $user->getUserProfilePictureUrl());

            return new Response(json_encode($user_final));
        }
        return new Response("erreur...");
    }



    public function addChatMessageAction(Request $request) {

        if($request->isXmlHttpRequest())
        {
            $content = $request->get('msg_content');
            $date = $request->get('msg_date');
            $idTable = $request->get('id_table');

            if (!empty($content) && !empty($date) && !empty($idTable)) {
                $em = $this->getDoctrine()->getManager();
                $user = $this->getUser();
                $table = $em->getRepository('AGILChatBundle:AgilChatTable')->find($idTable);

                if ($user != null && $table != null) {
                    $message = new AgilChatMessage($user, $table, $content, new \DateTime($date));
                    $em->persist($message);
                    $em->flush($message);
                }
            }
        }
        return new Response();
    }

    public function loadChatMessageAction(Request $request) {

        if($request->isXmlHttpRequest())
        {
            $offset = $request->get('nb_msg');
            $idTable = $request->get('id_table');

            if (!empty($offset) && !empty($idTable)) {
                $em = $this->getDoctrine()->getManager();
                $table = $em->getRepository('AGILChatBundle:AgilChatTable')->find($idTable);

                if (!empty($table)) {
                    $messages = $em->getRepository('AGILChatBundle:AgilChatMessage')->findBy(
                        array('table' => $table),
                        array('chatMessageDate' => 'ASC'),
                        100,
                        $offset
                    );

                    return $this->render('AGILChatBundle:Default:lastMessages.html.twig', array('lastMessages' => $messages));
                }
            }
        }

    }
}
