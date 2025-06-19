<?php

namespace App\Api\Cart\Domain\Contract\UseCase;

use App\Api\Cart\Domain\Contract\Dto\CartDtoInterface;

interface GetCartUseCaseInterface {
    public function __invoke($id): CartDtoInterface;
}
