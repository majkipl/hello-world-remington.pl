<?php

namespace App\Models;

use App\Traits\CacheModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Shop extends Model
{
    use HasFactory, CacheModelTrait;

    protected $fillable = ['name'];

    public $timestamps = false;

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
