<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddProductRequest;
use App\Http\Requests\Api\IndexProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use App\Traits\ApiRequestParametersTrait;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ApiRequestParametersTrait, ApiResponseTrait;

    /**
     * @param IndexProductRequest $request
     * @return JsonResponse
     */
    public function index(IndexProductRequest $request): JsonResponse
    {
        $params = $this->getRequestParameters($request);
        extract($params);

        $query = Product::search($search, $searchable)->filter($filter)->orderBy($sort, $order);

        $itemsCount = $query->count('id');
        $items = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'total' => $itemsCount,
            'rows' => $items
        ], Response::HTTP_OK);
    }


    public function add(AddProductRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $product = new Product($request->validated());

            $product->save();

            DB::commit();

            Cache::forget('products');

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.product')
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->responseUnprocessable();
        }
    }

    /**
     * @param UpdateProductRequest $request
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->input('id'));

            $product->fill($request->validated());
            $product->save();

            DB::commit();

            Cache::forget('products');

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.product')
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->responseUnprocessable();
        }
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function delete(Product $product): JsonResponse
    {
        DB::beginTransaction();

        try {
            Cache::forget('product_links_' . $product->id);

            $product->delete();

            DB::commit();

            Cache::forget('products');

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Rekord został pomyślnie usunięty.'
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->responseUnprocessable();
        }
    }
}

