<?php
require_once 'shippable.php';

class ShippableProduct extends Product implements shippable
{
    protected float $weight;

    public function __construct($name,$price,$quantity, float $weight)
    {
        parent::__construct($name,$price,$quantity);
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