<?php

namespace App\Api\Cart\Domain\Contract\UseCase;

use App\Api\Cart\Domain\Contract\Dto\CartDtoInterface;

interface AddItemToCartUseCaseInterface {
    public function __invoke($id, array $payload): CartDtoInterface;
}
