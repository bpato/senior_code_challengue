<?php

namespace App\Api\Cart\Application\Dto;

class CartItemSnapshot
{
    public function __construct(
        public int $product_id,
        public int $quantity,
    ) {}
}
