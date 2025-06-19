<?php
namespace App\Api\Checkout\Domain\Entity;

use App\Api\Checkout\Domain\ValueObject\Price;
use App\Api\Checkout\Domain\ValueObject\ProductId;
use App\Api\Checkout\Domain\ValueObject\ProductName;

class Product
{
    private ProductId $id;
    private ProductName $name;
    private Price $price;

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function setId(ProductId $id): self
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
}
