<?php

namespace App\Api\Cart\Infrastructure\Presenter;

use Symfony\Component\HttpFoundation\JsonResponse;

class DataApiPresenter
{
    public function present(array $data): JsonResponse
    {
        return new JsonResponse([
            'cart' => $data
        ]);
    }
}
