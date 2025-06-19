<?php

namespace App\Api\Cart\Application\CommandHandler;

use App\Api\Cart\Application\Command\DeleteCartCommand;
use App\Api\Cart\Domain\Exception\CartNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

#[AsMessageHandler]
class DeleteCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {
    }

    public function __invoke(DeleteCartCommand $command): void
    {
        $cartId = $command->getCartId();

        if( ! $cart = $this->cartRepository->findById($cartId)) {
            throw new CartNotFoundException($cartId);
        }

        $this->cartRepository->delete($cart);
    }
}
