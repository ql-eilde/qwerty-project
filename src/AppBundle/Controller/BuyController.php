<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\QProduct;

class BuyController extends Controller
{
    //TODO : Add validations (product exist ...)

    public function indexAction()
    {
        $products = $this->getDoctrine()->getManager()->getRepository('AppBundle:QProduct')->findAll();

        return $this->render('AppBundle:Buy:index.html.twig', array(
            'products' => $products,
        ));
    }

    public function viewAction(QProduct $product)
    {
        return $this->render('AppBundle:Buy:view.html.twig', array(
            'product' => $product,
        ));
    }
}
