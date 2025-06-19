<?php
namespace App\Api\Cart\Application\UseCase;

use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Application\Dto\CartDto;
use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\Messenger\HandleTrait;
use App\Api\Cart\Application\Query\GetCartQuery;
use App\Api\Cart\Application\Command\AddCartCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Api\Cart\Application\Command\DeleteCartCommand;
use App\Api\Cart\Domain\Contract\Dto\CartDtoFactoryInterface;
use App\Api\Cart\Domain\Contract\UseCase\CreateCartUseCaseInterface;

class CreateCartUseCase implements CreateCartUseCaseInterface
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $commandBus,
        MessageBusInterface $queryBus,
        private CartDtoFactoryInterface $cartDtoFactory
    )
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke($id = null): CartDto
    {
        if (! empty($id)) {
            $cartId = new CartId($id);
            $this->commandBus->dispatch(new DeleteCartCommand($cartId));
        }

        $cartId = new CartId();

        $this->commandBus->dispatch(new AddCartCommand($cartId));

        /** @var Cart $cart */
        $cart = $this->handle(new GetCartQuery($cartId));

        $cartDto = $this->cartDtoFactory->create($cart);

        return $cartDto;
    }
}
