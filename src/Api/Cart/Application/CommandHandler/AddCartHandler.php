<?php

namespace App\Api\Cart\Application\CommandHandler;

use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Application\Command\AddCartCommand;
use App\Api\Cart\Domain\Exception\CartNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Cart\Application\Exception\CartNotSavedException;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

#[AsMessageHandler]
class AddCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {
    }

    public function __invoke(AddCartCommand $command): void
    {

        $cartId = $this->cartRepository->save(new Cart($command->getCartId()));

        if (!$cartId->getValue() || $cartId->getValue() !== $command->getCartId()->getValue())
        {
            throw new CartNotSavedException();
        }
    }
}
