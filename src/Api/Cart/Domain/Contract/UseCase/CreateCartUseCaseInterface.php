<?php

namespace App\Api\Cart\Domain\Contract\UseCase;

use App\Api\Cart\Domain\Contract\Dto\CartDtoInterface;

interface CreateCartUseCaseInterface {
    public function __invoke($id = null): CartDtoInterface;
}
