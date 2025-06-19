<?php

namespace App\Api\Cart\Application\CommandHandler;

use App\Api\Cart\Application\Command\ClearCartCommand;
use App\Api\Cart\Domain\Exception\CartNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

#[AsMessageHandler]
class ClearCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {
    }

    public function __invoke(ClearCartCommand $command): void
    {
        $cartId = $command->getCartId();

        if( ! $cart = $this->cartRepository->findById($cartId)) {
            throw new CartNotFoundException($cartId);
        }

        $cart->clear();

        if (!$cart = $this->cartRepository->update($cart)) {
            throw new CartNotFoundException($cartId);
        }
    }
}
