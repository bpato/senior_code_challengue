<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\ProductId;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class ProductIdTest extends TestCase
{
    public function testCanCreateValidQuantity()
    {
        $productId = new ProductId(3);
        $this->assertEquals(3, $productId->getValue());
    }

    public function testZeroThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new ProductId(0);
    }

    public function testNegativeQuantityThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new ProductId(-5);
    }
}
