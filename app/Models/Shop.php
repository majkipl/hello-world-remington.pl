<?php

namespace App\Models;

use App\Traits\CacheModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Shop extends Model
{
    use HasFactory, CacheModelTrait;

    protected $fillable = ['name'];

    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * @param $query
     * @param $search
     * @param $searchable
     * @return mixed
     */
    public function scopeSearch($query, $search, $searchable)
    {
        if ($search && $searchable) {
            $query->where(function ($query) use ($search, $searchable) {
                foreach ($searchable as $column) {
                    switch ($column) {
                        case 'id':
                            $query->orWhere('id', '=', '%' . $search . '%');
                            break;
                        case 'name':
                            $query->orWhere($column, 'LIKE', '%' . $search . '%');
                            break;
                    }
                }
            });
        }

        return $query;
    }

    /**
     * @param $query
     * @param $filter
     * @return mixed
     */
    public function scopeFilter($query, $filter)
    {
        if ($filter) {
            $filters = json_decode($filter, true);

            foreach ($filters as $column => $value) {
                switch ($column) {
                    case 'id':
                        $query->where('id', $value);
                        break;
                    case 'name':
                        $query->where($column, 'LIKE', "%$value%");
                        break;
                }
            }
        }

        return $query;
    }
}
