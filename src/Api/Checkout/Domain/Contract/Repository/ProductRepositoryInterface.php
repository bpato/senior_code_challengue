<?php

namespace App\Api\Checkout\Domain\Contract\Repository;

use App\Api\Checkout\Domain\Entity\Product;
use App\Api\Checkout\Domain\ValueObject\ProductId;

interface ProductRepositoryInterface {
    public function findById(ProductId $id): ?Product;
}
