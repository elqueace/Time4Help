<?php

namespace App\Controller\Front;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

/**
 * @Route("/messages", name="front_message_")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * Affiche tous les messages reçus et envoyés de l'utilisateur courant
     */
    public function index(MessageRepository $messageRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $messages = $messageRepository->findAllMessages($user);
        $messages_array = array();
        $receivers_array = array();

        // On regroupe les messages des utilisateurs
        foreach ($messages as $message) {
            if ($message->getReceiver() && $message->getSender() && !in_array($message->getReceiver(), $receivers_array)) {
                array_push($receivers_array, $message->getSender());
                array_push($receivers_array, $message->getReceiver());
                array_push($messages_array, $message);
            }
        }

        return $this->render('front/message/index.html.twig', [
            $this->render('partials/vertical-nav.html.twig', [
                'count' => (int)$messageRepository->countMessageStatus($user, "envoyé")
            ]),
            'messages' => $messages_array
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET","POST"})
     * Affiche tous les messages avec un utilisateur en particulier
     */
    public function show(MessageRepository $messageRepository, Request $request, User $other): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setStatus("envoyé");
            $message->setSender($user);
            $message->setReceiver($other);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('front/message/show.html.twig', [
            'messages' => $messageRepository->findAllMessagesUsers($user, $other),
            'form' => $form->createView(),
            'user' => $user,
            'other' => $other
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index', [
                'id' => $message->getId(),
            ]);
        }

        return $this->render('front/message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_message_show', ['id'=> $message->getReceiver()->getId()]);
    }

    /**
     * @Route("/count/{status}", name="count_status", methods={"GET"})
     * Compte tous les messages avec un param status
     */
    public function count_status(MessageRepository $messageRepository, string $status)
    {
        $user = $this->getUser();
        $count = $messageRepository->countMessageStatus($user, $status);
        return new JsonResponse($count[0][1]);
    }
}
