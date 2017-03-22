<?php

namespace AppBundle\Controller;

use AppBundle\Entity\QProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function addAction(Request $request, QProduct $product)
    {
        $session = $request->getSession();
        if(!$session->has('cart'))
        {
            $session->set('cart', array());
        }
        $add = $session->get('cart');
        $add[] = $product;
        $session->set('cart', $add);

        return $this->redirectToRoute('cart');
    }

    public function viewAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('AppBundle:Cart:view.html.twig', array(
            'session' => $session->get('cart'),
            'total_price' => $this->container->get('app.cart')->getTotalPriceForCart($session->get('cart')),
        ));
    }

    public function deleteAction(Request $request, QProduct $product)
    {
        $cart = $request->getSession()->get('cart');
        foreach($cart as $key => $item)
        {
            if($item->getId() === $product->getId())
            {
                unset($cart[$key]);
                $request->getSession()->set('cart', $cart);
            }
        }
        return $this->redirectToRoute('cart');
    }

    public function clearAction(Request $request)
    {
        $request->getSession()->clear('cart');

        return $this->redirectToRoute('cart');
    }
}