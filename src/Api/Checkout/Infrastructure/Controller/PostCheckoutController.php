<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Api\Checkout\Infrastructure\Presenter\DataApiPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\Checkout\Infrastructure\Validator\PurchaseOrderRequestDto;
use App\Api\Checkout\Domain\Contract\UseCase\CreateOrderUseCaseInterface;


#[Route('/api/checkout', name: 'api_post_checkout', methods: 'POST')]
final class PostCheckoutController extends AbstractController
{
    public function __construct(
        private CreateOrderUseCaseInterface $createOrderUseCase,
        private SerializerInterface $serializer
    )
    {
    }

    public function __invoke(Request $request, PurchaseOrderRequestDto $purchaseOrderRequest, DataApiPresenter $presenter): JsonResponse
    {

        if (empty($request->getContent())) {
            return new JsonResponse(['error' => 'Request body cannot be empty'], 400);
        }

        $purchaseOrderRequest->populate($request->toArray());
        $errors = $purchaseOrderRequest->validate();

        if (count($errors) > 0) {
            return new JsonResponse(['errors' => $errors], 400);
        }

        try {
            $orderDto = $this->createOrderUseCase->__invoke($purchaseOrderRequest->toArray());

            $data = $this->serializer->serialize($orderDto, 'json', [
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
