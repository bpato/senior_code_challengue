<?php
namespace App\Api\Cart\Infrastructure\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class CartItemRequestDto extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $product_id;

    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $quantity;
}
