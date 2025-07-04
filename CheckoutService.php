<?php

require_once 'Product.php';
require_once 'Cart.php';
require_once 'Customer.php';

class CheckoutService
{
    public function checkout(Customer $customer, Cart $cart): void
    {
        if ($cart->isEmpty()) {
            throw new Exception("Cart is empty.");
        }

        $subtotal = 0;
        $shippingItems = [];
        $shippingCostPerKg = 30;
        $totalWeight = 0;

        // === Shipment Notice ===
        echo "- * Shipment notice **\n\n";

        foreach ($cart->getItems() as $item) {
            $product = $item->product;

            // Check expiration and availability
            if ($product->isExpired()) {
                throw new Exception("Product {$product->getName()} is expired.");
            }

            if (!$product->isAvailable($item->quantity)) {
                throw new Exception("Not enough quantity for {$product->getName()}.");
            }

            // Accumulate subtotal
            $subtotal += $product->getPrice() * $item->quantity;

            // Handle shippable products
            if ($product instanceof Shippable) {
                $weight = $product->getWeight() * $item->quantity;
                $totalWeight += $weight;
                printf("%-15s %4dg\n", "{$item->quantity}x " . $product->getName(), $weight);
            }
        }

        if ($totalWeight > 0) {
            printf("\nTotal package weight %.1fkg\n", $totalWeight / 1000);
        }

        // === Checkout Receipt ===
        echo "\n- * Checkout receipt **\n\n";

        foreach ($cart->getItems() as $item) {
            $lineTotal = $item->product->getPrice() * $item->quantity;
            printf("%-15s %5.0f\n", "{$item->quantity}x " . $item->product->getName(), $lineTotal);
        }

        echo str_repeat("-", 21) . "\n";

        $shippingFee = ($totalWeight / 1000) * $shippingCostPerKg;
        $total = $subtotal + $shippingFee;

        printf("Subtotal%13.0f\n", $subtotal);
        printf("Shipping%13.0f\n", $shippingFee);
        printf("Amount%15.0f\n", $total);

        // Balance check
        if (!$customer->hasEnoughBalance($total)) {
            throw new Exception("Customer does not have enough balance.");
        }

        $customer->charge($total);
    }
}
