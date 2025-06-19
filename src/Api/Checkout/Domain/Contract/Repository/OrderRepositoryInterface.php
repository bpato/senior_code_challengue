<?php

namespace App\Api\Checkout\Domain\Contract\Repository;

use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Domain\ValueObject\OrderId;

interface OrderRepositoryInterface {
    public function save(Order $order): ?OrderId;
    public function findById(OrderId $id): ?Order;
}
