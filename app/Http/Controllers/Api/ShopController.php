<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddShopRequest;
use App\Http\Requests\Api\IndexShopRequest;
use App\Http\Requests\Api\UpdateShopRequest;
use App\Models\Shop;
use App\Traits\ApiRequestParametersTrait;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    use ApiRequestParametersTrait, ApiResponseTrait;

    /**
     * @param IndexShopRequest $request
     * @return JsonResponse
     */
    public function index(IndexShopRequest $request): JsonResponse
    {
        $params = $this->getRequestParameters($request);
        extract($params);

        $query = Shop::search($search, $searchable)->filter($filter)->orderBy($sort, $order);

        $itemsCount = $query->count('id');
        $items = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'total' => $itemsCount,
            'rows' => $items
        ], Response::HTTP_OK);
    }

    /**
     * @param AddShopRequest $request
     * @return JsonResponse
     */
    public function add(AddShopRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $shop = new Shop($request->validated());

            $shop->save();

            DB::commit();

            Cache::forget('shops');

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.shop')
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
     * @param UpdateShopRequest $request
     * @return JsonResponse
     */
    public function update(UpdateShopRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $shop = Shop::findOrFail($request->input('id'));

            $shop->fill($request->validated());
            $shop->save();

            DB::commit();

            Cache::forget('shops');

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.shop')
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
     * @param Shop $shop
     * @return JsonResponse
     */
    public function delete(Shop $shop): JsonResponse
    {
        DB::beginTransaction();

        try {
            $shop->delete();

            DB::commit();

            Cache::forget('shops');

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
