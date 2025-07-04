<?php

class Customer
{
    public $name;
    public $balance;
    public function __construct($name, $balance)
    {
        $this->name = $name;
        $this->balance = $balance;
    }

    public function charge($amount)
    {
        return $this->balance -= $amount;
    }

    public function hasEnoughBalance($amount)
    {
        return $this->balance >= $amount;
    }

}


