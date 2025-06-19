<?php

namespace App\Api\Checkout\Infrastructure\Presenter;

use Symfony\Component\HttpFoundation\JsonResponse;

class DataApiPresenter
{
    public function present(array $data): JsonResponse
    {
        return new JsonResponse([
            'order' => $data
        ]);
    }
}
