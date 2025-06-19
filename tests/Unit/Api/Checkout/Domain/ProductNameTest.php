<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\ProductName;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class ProductNameTest extends TestCase
{
    public function testCanCreateValidQuantity()
    {
        $productName = new ProductName("test");
        $this->assertEquals("test", $productName->getValue());
    }

    public function testZeroThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new ProductName("");
    }
}
