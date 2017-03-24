<?php

namespace AppBundle\Controller;

use AppBundle\Entity\QIban;
use AppBundle\Entity\QProduct;
use AppBundle\Form\IbanType;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SellController extends Controller
{
    public function indexAction(Request $request)
    {
        //Page de présentation
        return $this->render('AppBundle:Sell:index.html.twig');
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function addAction(Request $request)
    {
        $product = new QProduct();
        $form = $this->createForm(ProductType::class, $product);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $user = $this->getUser();
            $request->getSession()->set('product', $product);
            if($user->getIban() !== null)
            {
                return $this->redirectToRoute('sell_recap');
            }
            return $this->redirectToRoute('sell_iban');
        }

        return $this->render('AppBundle:Sell:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function ibanAction(Request $request)
    {
        $iban = new QIban();
        $form = $this->createForm(IbanType::class, $iban);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $user = $this->getUser();
            $user->setIban($iban);
            $em = $this->getDoctrine()->getManager();
            $em->persist($iban);
            $em->flush();

            return $this->redirectToRoute('sell_recap');
        }
        return $this->render('AppBundle:Sell:iban.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function recapAction(Request $request)
    {
        return $this->render('AppBundle:Sell:recap.html.twig', array(
            'product' => $request->getSession()->get('product'),
            'user' => $this->getUser(),
        ));
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function validateAction(Request $request)
    {
        $product = $request->getSession()->get('product');
        $user = $this->getUser();
        $product->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        $request->getSession()->clear('product');

        return $this->redirectToRoute('buy');
    }
}
