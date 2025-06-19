<?php

namespace App\Api\Cart\Domain\Contract\Dto;

use App\Api\Cart\Domain\Entity\Cart;

interface CartDtoFactoryInterface
{
    public function create(Cart $cart): CartDtoInterface;
}
