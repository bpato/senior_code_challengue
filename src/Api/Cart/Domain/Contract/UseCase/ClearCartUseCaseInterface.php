<?php
namespace App\Api\Cart\Domain\Contract\UseCase;

use App\Api\Cart\Domain\Contract\Dto\CartDtoInterface;

interface ClearCartUseCaseInterface
{
    public function __invoke($id): CartDtoInterface;
}
