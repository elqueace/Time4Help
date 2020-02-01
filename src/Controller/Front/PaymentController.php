<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookingRepository;
use App\Entity\Booking;




class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    public function payment(Request $request, BookingRepository $bookingRepository)
    {
        $mealId = $request->get('mealId');
        $travellerId = $request->get('travellerId');
     

        $bookingRepository->updateBookingAfterPayment($mealId, $travellerId);
        
        return $this->render('payment/payment.html.twig', [
            
            'controller_name' => 'PaymentController',
        ]);
    }

     /**
     * @Route("/charge", name="charge")
     */
    public function charge(Request $request)
    {
        $price = $request->get('amount');
        $payment_id = $request->get('paymentId');

// Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_eVxSmneYt3p7j9FH32xajzmG');

        // Charge the Customer instead of the card:
        $charge = \Stripe\Charge::create([
            'amount' => 100 * $price,
            'currency' => 'eur',
            'customer' => $payment_id,
        ]);

        $this->addFlash(
            'notice',
            'Paiement effectué - Bon appetit !'
        );

       return $this->render('payment/payment.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
        
        
}
