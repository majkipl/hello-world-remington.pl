<?php

namespace App\Traits;

trait ApiRequestParametersTrait
{
    /**
     * @param $request
     * @return array
     */
    protected function getRequestParameters($request): array
    {
        $search = $request->input('search');
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $searchable = $request->input('searchable', []);
        $filter = $request->input('filter', []);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        return compact('search', 'offset', 'limit', 'searchable', 'filter', 'sort', 'order');
    }
}
