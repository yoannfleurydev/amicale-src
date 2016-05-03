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
use Symfony\Component\Validator\Constraints\DateTime;

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

//                var_dump($form->get('chatTablePassword') );
                if (!is_null($form->get('chatTablePassword')->getData())) {
                    $chatTable->setChatTablePassword(sha1($form->get('chatTablePassword')->getData()));
                }
                $chatTable->setChatTableDate(new \DateTime('now'));
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

    public function chatLiveAction(Request $request, $roomId)
    {
        $formSearchBar = $this->createForm(new SearchType());

        $manager = $this->getDoctrine()->getManager();
        $chatTableRepository = $manager->getRepository('AGILChatBundle:AgilChatTable');

        // Récupération de l'objet Category par rapport à l'ID spécifié dans l'URL
        $table = $chatTableRepository->find($roomId);
        if ($table != null) {
            $messages = $manager->getRepository('AGILChatBundle:AgilChatMessage')->findBy(
                array('table' => $table),
                array('chatMessageDate' => 'ASC'),
                100
            );
            $user = $this->getUser();
            // Si la table contient un mot de passe
            if ($table->getChatTablePassword() != null) {
                if ($request->isMethod("post")) {
                    if ($table->getChatTablePassword() == sha1($request->request->get('password'))) {
                        return $this->render('AGILChatBundle:Default:chatLive.html.twig', array(
                                'formSearchBar' => $formSearchBar->createView(),
                                'chatTable' => $table,
                                'user' => $user,
                                'messages' => $messages,
                                'lastMessages' => null)
                        );
                    } else {
                        $this->addFlash('warning', "Le mot de passe est incorrect");
                        return $this->redirectToRoute('agil_chat_homepage');
                    }
                } else {
                    $this->addFlash('warning', "Il faut entrer un mot de passe pour accéder au salon ".$table->getChatTableName());
                    return $this->redirectToRoute('agil_chat_homepage');
                }
            } else {
                $user = $this->getUser();
                return $this->render('AGILChatBundle:Default:chatLive.html.twig', array(
                        'formSearchBar' => $formSearchBar->createView(),
                        'chatTable' => $table,
                        'user' => $user,
                        'messages' => $messages,
                        'lastMessages' => null)
                );
            }
        } else {
            $this->addFlash('warning', "La table id " . $roomId . " n'existe pas .");
            return $this->redirectToRoute('agil_chat_homepage');
        }

    }

    public function deleteTableAction($roomId)
    {

        $em = $this->getDoctrine()->getManager();

        $table = $em->getRepository("AGILChatBundle:AgilChatTable")->find($roomId);
        $user = $this->getUser();

        if ($table === null) {
            if ($table === null) {
                $this->addFlash('warning', "La table " . $roomId . " n'existe pas.");
                return $this->redirect($this->generateUrl('agil_chat_homepage'));
            }

            return $this->redirect($this->generateUrl('agil_chat_homepage'));
        } else {
            if (!$user->hasRole('ROLE_MODERATOR') and !$user->hasRole('ROLE_ADMIN') and !$user->hasRole('ROLE_SUPER_ADMIN')
                and $user != $table->getUser()
            ) {
                $this->addFlash('warning', 'Permission refusée : vous n\'êtes pas le créateur du salon');

                return $this->redirect($this->generateUrl('agil_chat_table'));
            } else {

                $em->remove($table);
                $em->flush();

                $this->addFlash('success', "Le salon a été supprimé avec succès.");
                return $this->redirect($this->generateUrl('agil_chat_homepage'));
            }
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

    public function getDataTableAction(Request $req)
    {
        if ($req->isXMLHttpRequest()) {
            $idTable = $req->get('id_table');

            $em = $this->getDoctrine()->getManager();
            $chatTableRepository = $em->getRepository('AGILChatBundle:AgilChatTable');
            $chatTable = $chatTableRepository->find($idTable);
            $table = array('id' => $chatTable->getChatTableId(), 'pwd' => $chatTable->getChatTablePassword());
            return new Response(json_encode($table));
        }
        return new Response("erreur...");
    }


    public function addChatMessageAction(Request $request)
    {

        if ($request->isXmlHttpRequest()) {
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

    public function loadChatMessageAction(Request $request)
    {

        if ($request->isXmlHttpRequest()) {
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
