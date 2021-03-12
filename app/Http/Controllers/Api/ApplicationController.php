<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexApplicationRequest;
use App\Models\Application;
use App\Traits\ApiRequestParametersTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApplicationController extends Controller
{
    use ApiRequestParametersTrait;

    public function index(IndexApplicationRequest $request): JsonResponse
    {
        $params = $this->getRequestParameters($request);
        extract($params);

        $query = Application::search($search, $searchable)->filter($filter)->orderBy($sort, $order);

        $applicationsCount = $query->count('id');
        $applications = $query->offset($offset)->limit($limit)->get();

        return response()->json([
            'total' => $applicationsCount,
            'rows' => $applications
        ], Response::HTTP_OK);
    }
}
