<?php

namespace App\Api\Cart\Application\QueryHandler;

use App\Api\Cart\Application\Dto\CartSnapshot;
use App\Api\Cart\Application\Dto\CartItemSnapshot;
use App\Api\Cart\Domain\Exception\CartNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Checkout\Application\Query\GetCartSnapshotQuery;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

#[AsMessageHandler]
final class GetCartSnapshotHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
    )
    {
    }

    public function __invoke(GetCartSnapshotQuery $query)
    {
        $cartId = $query->getCartId();

        if( ! $cart = $this->cartRepository->findById($cartId)) {
            throw new CartNotFoundException($cartId);
        }

        $cartSnapshot = new CartSnapshot(
            $cart->getId()->getValue()
        );

        foreach ($cart->getItems() as $item) {
            $cartItemSnapshot = new CartItemSnapshot(
                $item->getProductId()->getValue(),
                $item->getQuantity()->getValue(),
            );

            $cartSnapshot->addItem($cartItemSnapshot);
        }

        return $cartSnapshot;
    }
}
