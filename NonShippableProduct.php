<?php

class NonShippableProduct extends Product
{

    public function __construct($name, $price, $quantity)
    {
        parent::__construct($name, $price, $quantity);
    }
}