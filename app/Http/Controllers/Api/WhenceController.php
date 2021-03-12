<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddWhenceRequest;
use App\Http\Requests\Api\IndexWhenceRequest;
use App\Http\Requests\Api\UpdateWhenceRequest;
use App\Models\Whence;
use App\Traits\ApiRequestParametersTrait;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WhenceController extends Controller
{
    use ApiRequestParametersTrait, ApiResponseTrait;

    /**
     * @param IndexWhenceRequest $request
     * @return JsonResponse
     */
    public function index(IndexWhenceRequest $request): JsonResponse
    {
        $params = $this->getRequestParameters($request);
        extract($params);

        $query = Whence::search($search, $searchable)->filter($filter)->orderBy($sort, $order);

        $itemsCount = $query->count('id');
        $items = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'total' => $itemsCount,
            'rows' => $items
        ], Response::HTTP_OK);
    }

    /**
     * @param AddWhenceRequest $request
     * @return JsonResponse
     */
    public function add(AddWhenceRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $whence = new Whence($request->validated());

            $whence->save();

            DB::commit();

            Cache::forget('whences');

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.whence')
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
     * @param UpdateWhenceRequest $request
     * @return JsonResponse
     */
    public function update(UpdateWhenceRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $whence = Whence::findOrFail($request->input('id'));

            $whence->fill($request->validated());
            $whence->save();

            DB::commit();

            Cache::forget('whences');

            return response()->json(
                [
                    'status' => 'success',
                    'results' => [
                        'url' => route('back.whence')
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
     * @param Whence $whence
     * @return JsonResponse
     */
    public function delete(Whence $whence): JsonResponse
    {
        DB::beginTransaction();

        try {
            $whence->delete();

            DB::commit();

            Cache::forget('whences');

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
