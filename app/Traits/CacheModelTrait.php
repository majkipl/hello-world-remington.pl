<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheModelTrait
{
    /**
     * @return mixed
     */
    public static function getAllCached()
    {
        $cacheKey = (new self)->getTable();

        return Cache::remember($cacheKey, now()->addDay(365), function () {
            return self::all();
        });
    }
}
