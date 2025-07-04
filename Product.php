<?php

abstract class Product
{

    protected $name;
    protected $price;
    protected $quantity;
    public function __construct($name, $price, $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }


    public function getName():string
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function reduceQuantity($amount)
    {
        return $this->quantity -= $amount;
    }
    public function isAvailable($reqAmount)
    {
        return $this->quantity >= $reqAmount;
    }
    public function isExpired() {
        return false;
    }

    public function requiresShipping() {
        return false;
    }


}