<?php
require_once 'shippable.php';
require_once 'ExpireProduct.php';

class ExpireShippableProduct extends ExpireProduct implements shippable
{
    protected float $weight;
    public function __construct($name, $price, $quantity,$expireDate, float $weight )
    {
        parent::__construct($name, $price, $quantity,$expireDate);
        $this->weight = $weight;
    }
    public function getWeight(): float {
        return $this->weight;
    }
    public function requiresShipping()
    {
        return true;
    }
}