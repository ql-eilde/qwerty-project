<?php

namespace AppBundle\Cart;

class Cart
{
    public function getTotalPriceForCart($cart)
    {
        $price = 0;

        if($cart === null)
        {
            return $price;
        }
        foreach($cart as $item)
        {
            $price += $item->getPrice();
        }
        return $price;
    }

    public function getItemsTotal($cart)
    {
        $total = 0;

        if($cart === null)
        {
            return $total;
        }
        foreach($cart as $item)
        {
            $total++;
        }
        return $total;
    }
}