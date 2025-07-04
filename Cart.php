<?php

class CartItem
{
    public Product $product;
    public int $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }
}

class Cart
{

    private array $items = [];

    public function add (Product $product, int $quantity): void
    {
        if (!$product->isAvailable($quantity)) {
            throw new Exception("Quantity not available for {$product->getName()}");
        }

        $this->items[] = new CartItem($product, $quantity);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }


}