<?php

namespace App\Api\Checkout\Domain\Contract\UseCase;

use App\Api\Checkout\Domain\Contract\Dto\OrderDtoInterface;

interface GetOrderUseCaseInterface
{
    public function __invoke($id): OrderDtoInterface;
}
