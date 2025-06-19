<?php

namespace App\Api\Cart\Infrastructure\Controller;

use App\Api\Cart\Domain\Contract\UseCase\CreateCartUseCaseInterface;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Infrastructure\Presenter\DataApiPresenter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/cart', name: 'api_post_cart', methods: 'POST')]
final class PostCartController extends AbstractController
{
    public function __construct(
        private CreateCartUseCaseInterface $createCartUseCase,
        private SerializerInterface $serializer
    )
    {
    }

    public function __invoke(Request $request, DataApiPresenter $presenter): JsonResponse
    {

        $header_cart_id = $request->headers->get(CartId::HEADER_KEY);
        try {
            $cartDto = $this->createCartUseCase->__invoke($header_cart_id);

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
