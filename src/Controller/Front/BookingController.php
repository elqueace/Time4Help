<?php

namespace App\Controller\Front;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bookings", name="front_booking_")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        // get the user id
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $myBookings = $bookingRepository->findMyBookings($user->getId());
        $myTravelersBookings = $bookingRepository->findMyTravelersBookings($user->getId());

        return $this->render('front/booking/index.html.twig', [
          'myBookings' => $myBookings,
          'myTravelersBookings' => $myTravelersBookings,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('front_booking_index');
        }

        return $this->render('front/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('front/booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_booking_index', [
                'id' => $booking->getId(),
            ]);
        }

        return $this->render('front/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_booking_index');
    }

    /**
     * @Route("/accepteHote/{id}", name="acceptehote", methods={"GET"})
     */
    public function accepteHote(Request $request, Booking $booking): Response
    {
        $booking->setIsAccepted(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();

        return $this->redirectToRoute('front_booking_index');
    }

    /**
     * @Route("/payHost/{id}", name="payHost", methods={"GET"})
     */
    public function payHost(Request $request, Booking $booking): Response
    {
        $booking->setIsPayed(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();

        return $this->redirectToRoute('front_booking_index');
    }
}
