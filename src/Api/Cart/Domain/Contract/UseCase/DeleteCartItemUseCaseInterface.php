<?php
namespace App\Api\Cart\Domain\Contract\UseCase;

use App\Api\Cart\Domain\Contract\Dto\CartDtoInterface;

interface DeleteCartItemUseCaseInterface
{
    public function __invoke($id, $productId): CartDtoInterface;
}
