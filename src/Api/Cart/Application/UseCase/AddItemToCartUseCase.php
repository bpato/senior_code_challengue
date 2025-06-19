<?php
namespace App\Api\Cart\Application\UseCase;

use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Application\Dto\CartDto;
use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\Messenger\HandleTrait;
use App\Api\Cart\Domain\ValueObject\ProductId;
use App\Api\Cart\Application\Query\GetCartQuery;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Api\Cart\Domain\ValueObject\CartItemQuantity;
use App\Api\Cart\Application\Command\AddItemToCartCommand;
use App\Api\Cart\Domain\Contract\Dto\CartDtoFactoryInterface;
use App\Api\Cart\Application\Exception\ProductNotFoundException;
use App\Api\Cart\Domain\Contract\Repository\ProductRepositoryInterface;
use App\Api\Cart\Domain\Contract\UseCase\AddItemToCartUseCaseInterface;

class AddItemToCartUseCase implements AddItemToCartUseCaseInterface
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

    public function __invoke($id = null, ?array $payload = null): CartDto
    {

        $cartId = new CartId($id);
        $productId = new ProductId($payload['product_id']);

        if (! $this->productRepository->findById($productId)) {
            throw new ProductNotFoundException($productId);
        }

        $cartItemQuantity = new CartItemQuantity($payload['quantity']);

        $this->commandBus->dispatch(new AddItemToCartCommand($cartId, $productId, $cartItemQuantity));

        /** @var Cart $cart */
        $cart = $this->handle(new GetCartQuery($cartId));

        $cartDto = $this->cartDtoFactory->create($cart);

        return $cartDto;
    }
}
