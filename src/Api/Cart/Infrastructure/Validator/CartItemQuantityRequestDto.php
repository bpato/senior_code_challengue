<?php
namespace App\Api\Cart\Infrastructure\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class CartItemQuantityRequestDto extends BaseRequest
{
    #[Assert\NotBlank]
    public int $quantity;
}
