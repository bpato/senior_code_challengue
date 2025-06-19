<?php

namespace App\Api\Cart\Application\CommandHandler;

use App\Api\Cart\Domain\Exception\CartNotFoundException;
use App\Api\Cart\Application\Command\UpdateCartItemQuantityCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

#[AsMessageHandler]
class UpdateCartItemQuantityHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {
    }

    public function __invoke(UpdateCartItemQuantityCommand $command): void
    {
        $cartId = $command->getCartId();

        if( ! $cart = $this->cartRepository->findById($cartId)) {
            throw new CartNotFoundException($cartId);
        }

        $cart->updateQuantityByProductId($command->getProductId(), $command->getCartItemQuantity());

        if (!$cart = $this->cartRepository->update($cart)) {
            throw new CartNotFoundException($cartId);
        }
    }
}
