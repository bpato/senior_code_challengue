<?php

namespace App\Api\Checkout\Domain\Contract\UseCase;

use App\Api\Checkout\Domain\Contract\Dto\OrderDtoInterface;

interface CreateOrderUseCaseInterface
{
    public function __invoke(?array $payload = null): OrderDtoInterface;
}
