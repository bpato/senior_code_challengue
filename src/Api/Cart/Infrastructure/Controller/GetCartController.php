<?php

namespace App\Api\Cart\Infrastructure\Controller;

use App\Api\Cart\Domain\ValueObject\CartId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Api\Cart\Infrastructure\Presenter\DataApiPresenter;
use App\Api\Cart\Domain\Contract\UseCase\GetCartUseCaseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/api/cart', name: 'api_get_cart', methods: 'GET')]
final class GetCartController extends AbstractController
{
    public function __construct(
        private GetCartUseCaseInterface $getCartUseCase,
        private SerializerInterface $serializer
    )
    {}

    public function __invoke(Request $request, DataApiPresenter $presenter): JsonResponse
    {
        $header_cart_id = $request->headers->get(CartId::HEADER_KEY);

        if (empty($header_cart_id)) {
            return new JsonResponse(['error' => 'Cart ID is required'], 400);
        }

        try {
            $cartDto = $this->getCartUseCase->__invoke($header_cart_id);

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
