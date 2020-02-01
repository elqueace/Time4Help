<?php

namespace App\Controller\Front;

use App\Entity\Address;
use App\Entity\Booking;
use App\Entity\Meal;
use App\Entity\Notation;
use App\Form\BookingType;
use App\Form\MealType;
use App\Form\NotationType;
use App\Repository\MealRepository;
use App\Repository\NotationRepository;
use App\Repository\AddressRepository;
use App\Repository\BookingRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/meals", name="front_meal_")
 */
class MealController extends AbstractController
{
    /**
 * @Route("/", name="index", methods={"GET"})
 */
    public function index(MealRepository $mealRepository): Response
    {
        //get the user id
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        //get the user's notations
        $meals = $mealRepository->findByHost($user);

        return $this->render('front/meal/index.html.twig', [
            'meals' => $meals,
        ]);
    }

    /**
     * @Route("/all", name="all", methods={"GET"})
     */
    public function allMeal(MealRepository $mealRepository): Response
    {
        //get the user id
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        //get the user's meals
        $meals = $mealRepository->findAllBesideMine($user);

        return $this->render('front/meal/all.html.twig', [
            'meals' => $meals,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $pictures = $form->get('pictures')->getData();
            foreach ($pictures as $file){
                $path = $file->getPath();
                $fileName = md5(uniqid()).'.'.$path->guessExtension();
                $path->move(
                    'images/meals/',
                    $fileName
                );
                $file->setPath( '/images/meals/'. $fileName);
            }
            $meal->setHost($this->getUser());

            foreach ($form->getData()->getPictures() as $key => $picture){
                $picture->setMeal($meal);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meal);
            $entityManager->flush();

            return $this->redirectToRoute('front_meal_index');
        }



        return $this->render('front/meal/new.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET","POST"})
     */
    public function show(BookingRepository $bookingRepository, NotationRepository $notationRepository, Meal $meal, Request $request): Response
    {
        //get the user id
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        //to add a notation for the meal
        $notation = new Notation();
        $notation->setMeal($meal);
        $notation->setGiver($user);
        $notation->setReceiver($meal->getHost());
        $formNotation = $this->createForm(NotationType::class, $notation);
        $formNotation->handleRequest($request);

        $booking = new Booking();
        $booking->setMeal($meal);
        $booking->setTraveler($user);
        $formBooking = $this->createForm(BookingType::class, $booking);
        $formBooking->handleRequest($request);

        $bookings = $bookingRepository->findIfAlreadyBooked($meal->getId());
        $booked = false;
        $payed = false;
        $commented = false;

        foreach($bookings as $booking)
        {
            //check if meal is already booked
            if($booking['traveler_id'] == $user->getId())
            {
                $booked = true;
                //check if meal is already payed
                if($booking['is_payed'] == true)
                {
                    $payed = true;
                }
            }
        }

        //check if meal is already commented
        $comments = $notationRepository->findIfAlreadyCommented($meal->getId(),$user->getId());

       /* foreach($comments as $comment)
        {
            if($comment.)
            {

            }
        }
*/
        if ($formNotation->isSubmitted() && $formNotation->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notation);
            $entityManager->flush();

            return $this->redirectToRoute('front_meal_show', ['id'=> $meal->getId()] );
        }

        if ($formBooking->isSubmitted() && $formBooking->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('front_booking_index', ['id'=> $meal->getId()] );
        }

        return $this->render('front/meal/show.html.twig', [
            'meal' => $meal,
            'notation' => $notation,
            'booking' => $booking,
            'booked' => $booked,
            'commented' => $commented,
            'payed' => $payed,
            'form' => $formNotation->createView(),
            'formBooking' => $formBooking->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Meal $meal): Response
    {
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_meal_index', [
                'id' => $meal->getId(),
            ]);
        }

        return $this->render('front/meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Meal $meal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_meal_index');
    }
}
