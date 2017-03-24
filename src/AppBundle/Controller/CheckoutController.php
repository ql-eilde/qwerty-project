<?php

namespace AppBundle\Controller;

use AppBundle\Form\AddressType;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends Controller
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function viewAction(Request $request)
    {
        //TODO : Put the address update in a service (FOSUserBundle:Profile:edit)
        $user = $this->getUser();
        $form = $this->createForm(AddressType::class, $user, array(
            'action' => $this->generateUrl('checkout'),
        ));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            return $this->redirectToRoute('checkout_pay');
        }

        return $this->render('AppBundle:Checkout:view.html.twig', array(
            'cart' => $request->getSession()->get('cart'),
            'total_price' => $this->container->get('app.cart')->getTotalPriceForCart($request->getSession()->get('cart')),
            'form' => $form->createView(),
        ));
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function payAction(Request $request)
    {
        //TODO : Put the payment process in a service
        //TODO : Custom the stripe integration
        $session = $request->getSession();

        $gatewayName = 'mygateway';

        $storage = $this->get('payum')->getStorage('AppBundle\Entity\Payment');

        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('EUR');
        $payment->setTotalAmount($this->container->get('app.cart')->getTotalPriceForCart($session->get('cart')) * 100); // 1.23 EUR
        $payment->setDescription('A description');
        $payment->setClientId($this->getUser()->getId());
        $payment->setClientEmail($this->getUser()->getEmail());

        $storage->update($payment);

        $captureToken = $this->get('payum')->getTokenFactory()->createCaptureToken(
            $gatewayName,
            $payment,
            'checkout_done' // the route to redirect after capture
        );

        return $this->redirect($captureToken->getTargetUrl());
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function doneAction(Request $request)
    {
        //TODO : Render a proper done page
        $token = $this->get('payum')->getHttpRequestVerifier()->verify($request);

        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        // you can invalidate the token. The url could not be requested any more.
        // $this->get('payum')->getHttpRequestVerifier()->invalidate($token);

        // Once you have token you can get the model from the storage directly.
        //$identity = $token->getDetails();
        //$payment = $this->get('payum')->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();

        // you have order and payment status
        // so you can do whatever you want for example you can just print status and payment details.

        return new JsonResponse(array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ),
        ));
    }
}