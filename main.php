<?php

require_once 'Product.php';
require_once 'ExpireShippableProduct.php';
require_once 'Cart.php';
require_once 'Customer.php';
require_once 'CheckoutService.php';
require_once 'ExpireProduct.php';
require_once 'NonShippableProduct.php';
require_once 'ShippableProduct.php';
require_once 'ExpireProduct.php';



$cheese = new ExpireShippableProduct('cheese',120,9,"2025-01-01",200.5);
$biscuits = new ExpireShippableProduct("Biscuits", 150, 5, "2025-12-01",30.5 );
$tv = new ShippableProduct('tv',2500,'10',5000.6);
$scratchCard = new NonShippableProduct('scratchCard',20,30,);

//
$customer = new Customer("Ahmed", 1000000);


$cart = new Cart();
$cart->add($cheese, 2);
$cart->add($biscuits, 1);
$cart->add($tv,2);


$checkout = new CheckoutService();
$checkout->checkout($customer, $cart);
