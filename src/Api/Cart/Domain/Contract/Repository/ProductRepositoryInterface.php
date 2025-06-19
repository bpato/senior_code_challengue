<?php

namespace App\Api\Cart\Domain\Contract\Repository;

use App\Api\Cart\Domain\ValueObject\ProductId;

interface ProductRepositoryInterface {
    public function findById(ProductId $id): ?object;
}
