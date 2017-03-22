<?php

namespace AppBundle\Cart;

class Cart
{
    public function getTotalPriceForCart($cart)
    {
        if($cart === null)
        {
            return 0;
        }
        $price = 0;
        foreach($cart as $item)
        {
            $price += $item->getPrice();
        }
        return $price;
    }
}