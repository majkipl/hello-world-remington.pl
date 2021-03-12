<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponseTrait
{
    /**
     * @return JsonResponse
     */
    protected function responseUnprocessable(): JsonResponse
    {
        return response()->json(
            [
                'errors' => [
                    'main' => [
                        'Nie możemy przetworzyć twojego żądania, aby rozwiązać problem skontaktuj się z administratorem serwisu.'
                    ]
                ],
                'message' => 'Wewnętrzny błąd serwisu.'
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
