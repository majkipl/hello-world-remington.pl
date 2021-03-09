<?php

namespace App\Http\Controllers;

use App\Enums\ShopType;
use App\Enums\Voivodeship;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Whence;
use App\Services\ApplicationService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class ApplicationController extends Controller
{
    public function __construct(private ApplicationService $applicationService)
    {
    }

    /**
     * @return View
     */
    public function form(): View
    {
        return view(
            'application/form',
            [
                'whences' => Whence::getAllCached(),
                'shops' => Shop::getAllCached(),
                'products' => Product::getAllCached(),
                'voivodeships' => Voivodeship::ALL,
                'shopTypes' => ShopType::TYPES
            ]
        );
    }

    public function store(StoreApplicationRequest $request)
    {
        try {
            $application = $this->applicationService->store(
                $request->validated(),
                $request
            );

            $request->session()->put('application_id', $application->id);

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('front.thx.form')
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'errors' => [
                        'main' => [
                            'Nie możemy dodać Twojego zgłoszenia, aby rozwiązać problem skontaktuj się z administratorem serwisu.'
                        ]
                    ],
                    'message' => 'Wewnętrzny błąd serwisu.'
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
