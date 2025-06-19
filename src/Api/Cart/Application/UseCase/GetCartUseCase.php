<?php
namespace App\Api\Cart\Application\UseCase;

use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Application\Dto\CartDto;
use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\Messenger\HandleTrait;
use App\Api\Cart\Application\Query\GetCartQuery;
use App\Api\Cart\Domain\Contract\Dto\CartDtoFactoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Api\Cart\Domain\Contract\UseCase\GetCartUseCaseInterface;

class GetCartUseCase implements GetCartUseCaseInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus,
        private CartDtoFactoryInterface $cartDtoFactory
    )
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke($id): CartDto
    {

        $cartId = new CartId($id);

        /** @var Cart $cart */
        $cart = $this->handle(new GetCartQuery($cartId));

        $cartDto = $this->cartDtoFactory->create($cart);

        return $cartDto;
    }
}
