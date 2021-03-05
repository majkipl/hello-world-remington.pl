<?php

namespace App\Models;

use App\Traits\CacheModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Whence extends Model
{
    use HasFactory, CacheModelTrait;

    protected $fillable = ['name'];

    public $timestamps = false;
}
