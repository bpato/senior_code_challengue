<?php

namespace App\Api\Cart\Application\CommandHandler;

use App\Api\Cart\Domain\Entity\CartItem;
use App\Api\Cart\Domain\Exception\CartNotFoundException;
use App\Api\Cart\Application\Command\AddItemToCartCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

#[AsMessageHandler]
class AddItemToCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {
    }

    public function __invoke(AddItemToCartCommand $command): void
    {
        $cartId = $command->getCartId();

        if( ! $cart = $this->cartRepository->findById($cartId)) {
            throw new CartNotFoundException($cartId);
        }

        $newCartItem = new CartItem(
            $command->getProductId(),
            $command->getCartItemQuantity()
        );

        $cart->addItem($newCartItem);

        if (!$cart = $this->cartRepository->update($cart)) {
            throw new CartNotFoundException($cartId);
        }
    }
}
