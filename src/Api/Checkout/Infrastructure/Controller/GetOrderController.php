<?php

namespace App\Api\Checkout\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Api\Checkout\Infrastructure\Presenter\DataApiPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\Checkout\Domain\Contract\UseCase\GetOrderUseCaseInterface;

#[Route('/api/order/{id}', name: 'api_get_order', methods: 'GET')]
final class GetOrderController extends AbstractController
{
    public function __construct(
        private GetOrderUseCaseInterface $getOrderUseCase,
        private SerializerInterface $serializer
    )
    {}

    public function __invoke(Request $request, DataApiPresenter $presenter): JsonResponse
    {
        $orderId = $request->attributes->get('id');
        if (empty($orderId)) {
            return new JsonResponse(['error' => 'Order ID is required'], 400);
        }

        try {
            $orderDto = $this->getOrderUseCase->__invoke($orderId);

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
