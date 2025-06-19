<?php

namespace App\Tests\Unit\Api\Checkout\Domain;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Api\Checkout\Domain\ValueObject\CartId;
use App\Api\Checkout\Domain\Exception\InvalidArgumentException;

class CartIdTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function testCanCreateValidId()
    {
        $id = $this->faker->uuid();
        $cartId = new CartId($id);
        $this->assertEquals($id, $cartId->getValue());
    }

    public function testInvalidUuidThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new CartId('uuid-1');
    }
}
