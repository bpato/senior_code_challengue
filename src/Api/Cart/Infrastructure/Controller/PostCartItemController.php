<?php

namespace App\Api\Cart\Infrastructure\Controller;

use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Api\Cart\Infrastructure\Presenter\DataApiPresenter;
use App\Api\Cart\Infrastructure\Validator\CartItemRequestDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\Cart\Domain\Contract\UseCase\AddItemToCartUseCaseInterface;


#[Route('/api/cart/items', name: 'api_post_cart_items', methods: 'POST')]
final class PostCartItemController extends AbstractController
{
    public function __construct(
        private AddItemToCartUseCaseInterface $addItemToCartUseCase,
        private SerializerInterface $serializer
    )
    {
    }

    public function __invoke(Request $request, CartItemRequestDto $cartItemRequest, DataApiPresenter $presenter): JsonResponse
    {

        $header_cart_id = $request->headers->get(CartId::HEADER_KEY);

        if (empty($header_cart_id)) {
            return new JsonResponse(['error' => 'Cart ID is required'], 400);
        }

        if (empty($request->getContent())) {
            return new JsonResponse(['error' => 'Request body cannot be empty'], 400);
        }

        $cartItemRequest->populate($request->toArray());
        $errors = $cartItemRequest->validate();

        if (count($errors) > 0) {
            return new JsonResponse(['errors' => $errors], 400);
        }

        try {
            $cartDto = $this->addItemToCartUseCase->__invoke($header_cart_id, $cartItemRequest->toArray());

            $data = $this->serializer->serialize($cartDto, 'json', [
                'groups' => ['*']
            ]);

            return $presenter->present(json_decode($data, true));

        } catch (\RuntimeException $th) {
            return new JsonResponse(['error' => $th->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => 'An unexpected error occurred'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
