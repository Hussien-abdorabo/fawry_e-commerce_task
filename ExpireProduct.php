<?php

class ExpireProduct extends Product
{
    private Datetime $expireDate;
    public function __construct($name,$price,$quantity, string $expireDate)
    {
        parent::__construct($name,$price,$quantity);
        $this->expireDate = new Datetime($expireDate);
    }

    public function isExpired()
    {
        return $this->expireDate < new Datetime();
    }
}