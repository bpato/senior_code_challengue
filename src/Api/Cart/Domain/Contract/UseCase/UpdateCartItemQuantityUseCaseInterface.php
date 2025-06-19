<?php
namespace App\Api\Cart\Domain\Contract\UseCase;

use App\Api\Cart\Domain\Contract\Dto\CartDtoInterface;

interface UpdateCartItemQuantityUseCaseInterface
{
    public function __invoke($id, $productId, array $payload): CartDtoInterface;
}
