<?php

namespace App\Api\Checkout\Application\Exception;

use RuntimeException;
use App\Api\Checkout\Domain\ValueObject\ProductId;

class ProductNotFoundException extends RuntimeException
{
    public function __construct(ProductId $productId)
    {
        parent::__construct('Product not found with ID: ' . $productId->getValue());
    }
}
