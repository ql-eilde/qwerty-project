<?php

namespace AppBundle\Controller;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends Controller
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function payAction(Request $request)
    {
        //TODO : Put this in a service
        if($request->isMethod('POST'))
        {
            $user = $this->getUser();
            $user->setStreet($_POST['stripeShippingAddressLine1']);
            $user->setCity($_POST['stripeShippingAddressCity']);
            $user->setPostcode($_POST['stripeShippingAddressZip']);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            Stripe::setApiKey($this->getParameter('sk_key'));
            $token = $_POST['stripeToken'];
            $customer = Customer::create(array(
                'email' => $_POST['stripeEmail'],
                'source' => $token,
            ));
            try {
                Charge::create(array(
                    "amount" => $this->container->get('app.cart')->getTotalPriceForCart($request->getSession()->get('cart')) * 100,
                    "currency" => "eur",
                    "description" => "Paiement Stripe - Qwerty",
                    'customer' => $customer->id,
                ));
                $request->getSession()->clear('cart');
                return $this->render('AppBundle:Checkout:success.html.twig');
            } catch(Card $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return $this->render('AppBundle:Checkout:failure.html.twig', array(
                    'error' => $err,
                ));
            }
        }
        return $this->render('AppBundle:Checkout:pay.html.twig', array(
            'cart' => $request->getSession()->get('cart'),
            'user' => $this->getUser(),
            'amount' => $this->container->get('app.cart')->getTotalPriceForCart($request->getSession()->get('cart')),
        ));
    }
}