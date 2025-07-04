<?php

class CheckoutService {
    public function checkout(Customer $customer, Cart $cart): void {
        if ($cart->isEmpty()) {
            throw new Exception("Cart is empty.");
        }

        $subtotal = 0;
        $shippingItems = [];
        $shippingCostPerKg = 30;


        foreach ($cart->getItems() as $item) {
            $product = $item->product;

            if ($product->isExpired()) {
                throw new Exception("Product {$product->getName()} is expired.");
            }

            if (!$product->isAvailable($item->quantity)) {
                throw new Exception("Not enough quantity for {$product->getName()}.");
            }

            $subtotal += $product->getPrice() * $item->quantity;

            if ($product instanceof Shippable) {
                $shippingItems[] = $item;
                echo "{$item->quantity}x {$product->getName()}\t" . $product->getWeight() * $item->quantity . "g\n";
            }
        }

        $totalWeightGrams = array_reduce($shippingItems, function ($carry, $item) {
            $product = $item->product;
            return $carry + ($product->getWeight() * $item->quantity);
        }, 0);

        $shippingFee = ($totalWeightGrams / 1000) * $shippingCostPerKg;

        echo "Total package weight: " . number_format($totalWeightGrams / 1000, 2) . "kg\n\n";
        echo "** Checkout receipt \n";

        foreach ($cart->getItems() as $item) {
            echo "{$item->quantity}x {$item->product->getName()}\t" . ($item->product->getPrice() * $item->quantity) . "\n";
        }

        echo "Subtotal" . $subtotal . "\n";
        echo "Shipping" . $shippingFee . "\n";

        $total = $subtotal + $shippingFee;

        if (!$customer->hasEnoughBalance($total)) {
            throw new Exception("Customer does not have enough balance.");
        }

        $customer->charge($total);
        echo "Amount" . $total . "\n";
        echo "Customer balance after payment: {$customer->balance}\n";
    }
}
