<?php

namespace App\Api\Cart\Infrastructure\Controller;

use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Api\Cart\Infrastructure\Presenter\DataApiPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\Cart\Domain\Contract\UseCase\DeleteCartItemUseCaseInterface;

#[Route('/api/cart/items/{id}', name: 'api_delete_cart_items', methods: 'DELETE')]
class DeleteCartItemController extends AbstractController
{
    public function __construct(
        private DeleteCartItemUseCaseInterface $deleteCartItemUseCase,
        private SerializerInterface $serializer
    )
    {
    }

    public function __invoke(Request $request, DataApiPresenter $presenter): JsonResponse
    {
        $header_cart_id = $request->headers->get(CartId::HEADER_KEY);

        if (empty($header_cart_id)) {
            return new JsonResponse(['error' => 'Cart ID is required'], 400);
        }

        $productId = $request->attributes->get('id');
        if (empty($productId)) {
            return new JsonResponse(['error' => 'Product ID is required'], 400);
        }

        try {
            $cartDto = $this->deleteCartItemUseCase->__invoke($header_cart_id, $productId);

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
