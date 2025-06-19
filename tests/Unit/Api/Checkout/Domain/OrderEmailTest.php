<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\OrderEmail;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class OrderEmailTest extends TestCase
{
    public function testCanCreateValidEmail()
    {
        $orderEmail = new OrderEmail('test@example.com');
        $this->assertEquals('test@example.com', $orderEmail->getValue());
    }

    public function testInvalidEmailThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new OrderEmail('test');
    }
}
