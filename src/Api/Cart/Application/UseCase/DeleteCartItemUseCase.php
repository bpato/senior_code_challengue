<?php

namespace App\Api\Cart\Application\UseCase;

use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Application\Dto\CartDto;
use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\Messenger\HandleTrait;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Application\Query\GetCartQuery;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Api\Cart\Application\Command\DeleteCartItemCommand;
use App\Api\Cart\Domain\Contract\Dto\CartDtoFactoryInterface;
use App\Api\Cart\Application\Exception\ProductNotFoundException;
use App\Api\Cart\Domain\Contract\Repository\ProductRepositoryInterface;
use App\Api\Cart\Domain\Contract\UseCase\DeleteCartItemUseCaseInterface;

class DeleteCartItemUseCase implements DeleteCartItemUseCaseInterface
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $commandBus,
        MessageBusInterface $queryBus,
        private ProductRepositoryInterface $productRepository,
        private CartDtoFactoryInterface $cartDtoFactory
    )
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke($id, $productId): CartDto
    {
        $cartId = new CartId($id);
        $productId = new ProductId($productId);

        if (! $this->productRepository->findById($productId)) {
            throw new ProductNotFoundException($productId);
        }

        $this->commandBus->dispatch(new DeleteCartItemCommand($cartId, $productId));

        /** @var Cart $cart */
        $cart = $this->handle(new GetCartQuery($cartId));

        $cartDto = $this->cartDtoFactory->create($cart);

        return $cartDto;
    }
}
