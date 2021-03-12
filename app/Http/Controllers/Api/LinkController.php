<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddLinkRequest;
use App\Http\Requests\Api\IndexLinkRequest;
use App\Http\Requests\Api\UpdateLinkRequest;
use App\Models\Link;
use App\Models\Product;
use App\Traits\ApiRequestParametersTrait;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{
    use ApiRequestParametersTrait, ApiResponseTrait;

    /**
     * @param IndexLinkRequest $request
     * @return JsonResponse
     */
    public function index(IndexLinkRequest $request): JsonResponse
    {
        $params = $this->getRequestParameters($request);
        extract($params);

        $query = Link::with('product')->search($search, $searchable)->filter($filter)->orderBy($sort, $order);

        $itemsCount = $query->count('id');
        $items = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'total' => $itemsCount,
            'rows' => $items
        ], Response::HTTP_OK);
    }

    /**
     * @param AddLinkRequest $request
     * @return JsonResponse
     */
    public function add(AddLinkRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $link = new Link($request->validated());

            $link->save();

            DB::commit();

            Cache::forget('links');
            Cache::forget('product_links_' . $link->product_id);

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.link')
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
     * @param UpdateLinkRequest $request
     * @return JsonResponse
     */
    public function update(UpdateLinkRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $link = Link::findOrFail($request->input('id'));

            $link->fill($request->validated());
            $link->save();

            DB::commit();

            Cache::forget('links');
            Cache::forget('product_links_' . $link->product_id);

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.link')
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            DB::rollBack();

            return $this->responseUnprocessable();
        }
    }

    public function delete(Link $link): JsonResponse
    {
        DB::beginTransaction();

        try {
            Cache::forget('product_links_' . $link->product_id);

            $link->delete();

            DB::commit();

            Cache::forget('links');

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

    /**
     * @param Product $product
     * @param IndexLinkRequest $request
     * @return JsonResponse
     */
    public function byProduct(Product $product, IndexLinkRequest $request): JsonResponse
    {
        $params = $this->getRequestParameters($request);
        extract($params);

        $query = Link::withWhereHas('product', fn($query) => $query->where('id', '=', $product->id))
            ->search($search, $searchable)
            ->filter($filter)
            ->orderBy($sort, $order);

        $itemsCount = $query->count('id');
        $items = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'total' => $itemsCount,
            'rows' => $items
        ], Response::HTTP_OK);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function product(Product $product): JsonResponse
    {
        $cacheKey = 'product_links_' . $product->id;

        if (Cache::has($cacheKey)) {
            $links = Cache::get($cacheKey);
        } else {
            $links = Link::withWhereHas(
                'product',
                fn($query) => $query->where('id', '=', $product->id)
            )->get();

            Cache::remember($cacheKey, 60, function () use ($links) {
                return $links;
            });
        }

        return response()->json([
            'total' => $links->count('id'),
            'rows' => $links->pluck('url')
        ], Response::HTTP_OK);
    }
}
