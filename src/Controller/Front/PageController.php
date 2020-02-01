<?php

namespace App\Controller\Front;

use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Repository\MessageRepository;
use App\Repository\NotationRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\MealRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/", name="front_page_")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET","POST"}))
     */
    public function home(MealRepository $mealRepository, UserRepository $userRepository, NotationRepository $notationRepository)
    {

        $usersCount = $userRepository->countUsers();
        $mealsCount = $mealRepository->countMeals();
        $user = $this->getUser();
        if ($user !== NULL) {
            $commentaires = $notationRepository->getAllCommentsButMine($user->getId());
        } else {
            $commentaires = $notationRepository->getAllCommentsButMine();
        }


        return $this->render('front/page/home.html.twig', [
            'controller_name' => 'PageController',
            'usersCount' => $usersCount,
            'mealsCount' => $mealsCount,
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('front/page/about.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('front/page/contact.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/add_listing", name="add_listing")
     */
    public function add_listing()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('front/page/add_listing.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/change_password", name="change_password")
     */
    public function change_password()
    {
        return $this->render('front/page/change_password.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/reviews", name="reviews")
     */
    public function reviews()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('front/page/reviews.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/concept", name="concept")
     */
    public function concept()
    {
        return $this->render('front/page/concept.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/member", name="member")
     */
    public function member()
    {
        return $this->render('front/page/member.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/listing", name="listing")
     */
    public function listing(Request $request, AddressRepository $addressRepository, MealRepository $mealRepository)
    {

        $addresses = $addressRepository->findByAddress($request->query->get('searchAddress'));

        $meals = [];
        foreach ($addresses as $address) {
            $mealsTest = $mealRepository->findBy(['address' => $address]);
            foreach ($mealsTest as $meal) {
                array_push($meals, $meal);
            }
        }
//dd($meals);
        return $this->render('front/page/listing.html.twig', [
            'meals' => $meals,
            'adress' => $request->query->get('searchAddress'),
        ]);
    }
}
