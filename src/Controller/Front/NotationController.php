<?php

namespace App\Controller\Front;

use App\Entity\Notation;
use App\Form\NotationType;
use App\Repository\NotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notations", name="front_notation_")
 */
class NotationController extends AbstractController
{
    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $notation = new Notation();
        $notation->setDate(date("Y-m-d H:i:s"));
        $form = $this->createForm(NotationType::class, $notation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notation);
            $entityManager->flush();

            return $this->redirectToRoute('front_notation_index');
        }

        return $this->render('front/notation/new.html.twig', [
            'notation' => $notation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user_notations", name="user_notations", methods={"GET"})
     */
    public function show(): Response
    {
        //get the user id
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        //get the user's notations
        $notations = $this->getDoctrine()->getRepository(Notation::class)->findByReceiver($user->getId());
    
        return $this->render('front/notation/notations.html.twig', [
            'notations' => $notations
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Notation $notation): Response
    {
        $form = $this->createForm(NotationType::class, $notation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_notation_index', [
                'id' => $notation->getId(),
            ]);
        }

        return $this->render('notations/edit.html.twig', [
            'notation' => $notation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Notation $notation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($notation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_notation_index');
    }
}
