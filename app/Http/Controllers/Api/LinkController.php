<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LinkController extends Controller
{
    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function product(Product $product): JsonResponse
    {
        $links = Link::withWhereHas(
            'product',
            fn($query) => $query->where('id', '=', $product->id)
        );

        // TODO: Add cache

        return response()->json([
            'total' => $links->count('id'),
            'rows' => $links->pluck('url')
        ], Response::HTTP_OK);
    }
}
