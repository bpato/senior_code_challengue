<?php

namespace App\Api\Checkout\Domain\Entity;

use App\Api\Checkout\Domain\ValueObject\CartId;
use App\Api\Checkout\Domain\ValueObject\OrderEmail;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Domain\ValueObject\Price;
use App\Api\Checkout\Domain\ValueObject\Quantity;

class Order {

    private OrderId $id;
    private CartId $cartReference;
    private OrderEmail $email;
    private \DateTimeImmutable $createdAt;
    private Price $totalPrice;
    private Quantity $totalQuantity;

    private array $orderProducts = [];

    public function getId(): OrderId
    {
        return $this->id;
    }

    public function setId(OrderId $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCartReference(): CartId
    {
        return $this->cartReference;
    }

    public function setCartReference(CartId $cartId): self
    {
        $this->cartReference = $cartId;

        return $this;
    }

    public function getEmail(): OrderEmail
    {
        return $this->email;
    }

    public function setEmail(OrderEmail $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getTotalQuantity(): Quantity
    {
        return $this->totalQuantity;
    }

    public function setTotalQuantity(Quantity $quantity): self
    {
        $this->totalQuantity = $quantity;

        return $this;
    }

    public function getOrderProducts(): iterable
    {
        foreach ($this->orderProducts as $orderProduct) {
            yield $orderProduct;
        }
    }

    public function calculateTotalPrice(): void
    {
        $totalPrice = 0.0;

        foreach ($this->orderProducts as $orderProduct) {
            $totalPrice += $orderProduct->getTotalPrice()->getValue();
        }

        $this->totalPrice = new Price($totalPrice);
    }

    public function calculateTotalQuantity(): void
    {
        $totalQuantity = 0;

        foreach ($this->orderProducts as $orderProduct) {
            $totalQuantity += $orderProduct->getQuantity()->getValue();
        }

        $this->totalQuantity = new Quantity($totalQuantity);
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        $this->orderProducts[] = $orderProduct;

        return $this;
    }
}
