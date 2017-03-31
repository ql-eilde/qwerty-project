<?php

namespace AppBundle\Controller;

use AppBundle\Entity\QOrder;
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

        $session = $request->getSession();

        if($request->isMethod('POST'))
        {
            $user = $this->getUser();
            $name = explode(" ", $_POST['stripeBillingName']);
            $user->setFirstName($name[0]);
            $user->setLastName($name[1]);
            $user->setShippingStreet($_POST['stripeShippingAddressLine1']);
            $user->setShippingCity($_POST['stripeShippingAddressCity']);
            $user->setShippingPostcode($_POST['stripeShippingAddressZip']);
            $user->setBillingStreet($_POST['stripeBillingAddressLine1']);
            $user->setBillingCity($_POST['stripeBillingAddressCity']);
            $user->setBillingPostcode($_POST['stripeBillingAddressZip']);
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
                    "amount" => $this->container->get('app.cart')->getTotalPriceForCart($session->get('cart')) * 100,
                    "currency" => "eur",
                    "description" => "Paiement Stripe - Qwerty",
                    'customer' => $customer->id,
                ));

                //Create Order(s)
                $manager = $this->getDoctrine()->getManager();

                foreach($session->get('cart') as $item)
                {
                    $order = new QOrder();
                    $product = $manager->merge($item);
                    $order->setProduct($product);
                    $order->setCustomer($this->getUser());
                    $order->setShippingState('shipping pending');
                    $manager->persist($order);
                }

                //Set publishable to false for product order
                foreach($session->get('cart') as $var)
                {
                    $prod = $manager->merge($var);
                    $prod->setPublishable(false);
                    $manager->persist($prod);
                }
                $manager->flush();

                //Clearing the cart
                $session->clear('cart');

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
            'amount' => $this->container->get('app.cart')->getTotalPriceForCart($session->get('cart')),
        ));
    }
}