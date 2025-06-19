<?php
namespace App\Api\Checkout\Infrastructure\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseOrderRequestDto extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public string $cart_id;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;
}
