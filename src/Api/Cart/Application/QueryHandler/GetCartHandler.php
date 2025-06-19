<?php

namespace App\Api\Cart\Application\QueryHandler;

use App\Api\Cart\Application\Query\GetCartQuery;
use App\Api\Cart\Domain\Exception\CartNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;

#[AsMessageHandler]
final class GetCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
    )
    {
    }

    public function __invoke(GetCartQuery $query)
    {
        $cartId = $query->getCartId();

        if( ! $cart = $this->cartRepository->findById($cartId)) {
            throw new CartNotFoundException($cartId);
        }

        return $cart;
    }
}
