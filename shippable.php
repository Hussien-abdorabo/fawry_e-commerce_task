<?php
interface shippable
{
    public function getName(): string;

    public function getWeight(): double;
}