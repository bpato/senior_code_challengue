<?php

namespace App\Api\Cart\Application\Dto;

use App\Api\Cart\Application\Dto\CartItemSnapshot;

class CartSnapshot
{

    public array $items = [];

    public function __construct(
        public string $id
    ) {}

    public function getItems(): iterable
    {
        foreach ($this->items as $item) {
            yield $item;
        }
    }

    public function addItem( CartItemSnapshot $item): void
    {
        $this->items[] = $item;
    }
}
