<?php

namespace App\Api\Cart\Application\Exception;

use RuntimeException;
use App\Api\Cart\Domain\ValueObject\ProductId;

class ProductNotFoundException extends RuntimeException
{
    public function __construct(ProductId $productId)
    {
        parent::__construct('Product not found with ID: ' . $productId->getValue());
    }
}
