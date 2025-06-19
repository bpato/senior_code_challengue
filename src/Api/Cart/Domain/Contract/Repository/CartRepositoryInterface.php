<?php

namespace App\Api\Cart\Domain\Contract\Repository;

use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;

interface CartRepositoryInterface {
    public function save(Cart $cart): CartId;
    public function findById(CartId $id): ?Cart;
    public function delete(Cart $cart): void;
    public function update(Cart $cart): ?Cart;
}
