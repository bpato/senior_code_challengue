<?php

namespace App\Tests\Unit\Api\Cart\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Domain\Exception\InvalidArgumentException;

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

    public function testCompareEquals()
    {
        $productId = new ProductId(3);
        $this->assertTrue($productId->equals(new ProductId(3)));
        $this->assertFalse($productId->equals(new ProductId(6)));

    }
}
