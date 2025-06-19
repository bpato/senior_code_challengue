<?php

namespace App\Api\Checkout\Domain\Entity;

use App\Api\Checkout\Domain\ValueObject\Price;
use App\Api\Checkout\Domain\ValueObject\Quantity;
use App\Api\Checkout\Domain\ValueObject\ProductId;
use App\Api\Checkout\Domain\ValueObject\ProductName;
use App\Api\Checkout\Domain\ValueObject\OrderProductId;

class OrderProduct
{
    private OrderProductId $id;
    private ProductId $productId;
    private ProductName $name;
    private Price $price;
    private Quantity $quantity;
    private Price $totalPrice;

    public function getId(): OrderProductId
    {
        return $this->id;
    }

    public function setId(OrderProductId $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function setName(ProductName $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function setProductId(ProductId $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function setQuantity(Quantity $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotalPrice(): Price
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(Price $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function calculateTotalPrice(): void
    {
        $this->totalPrice = new Price($this->getPrice()->getValue() * $this->getQuantity()->getValue());
    }
}
