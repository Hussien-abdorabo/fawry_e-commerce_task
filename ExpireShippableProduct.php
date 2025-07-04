<?php

class ExpireShippableProduct extends Product implements shippable
{
    protected double $weight;
    public function __construct($name, $price, $quantity,double $weight )
    {
        parent::__construct($name, $price, $quantity);
        $this->weight = $weight;
    }
    public function getWeight(): double
    {
        return $this->weight;
    }
    public function requiresShipping()
    {
        return true;
    }
}