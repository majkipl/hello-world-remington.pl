<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $img_receipt
 * @property string $img_ean
 * @property mixed $shop_id
 * @property mixed $product_id
 * @property mixed $whence_id
 * @property bool $legal_1
 * @property bool $legal_2
 * @property bool $legal_3
 * @property bool $legal_4
 * @property bool $legal_5
 * @property string $email
 * @property int $id
 */
class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname', 'lastname', 'address', 'city', 'zip', 'voivodeship', 'email', 'phone', 'shop_type', 'buyday',
        'number_receipt', 'img_receipt', 'img_ean', 'shop_id', 'product_id', 'whence_id',
        'legal_1', 'legal_2', 'legal_3', 'legal_4', 'legal_5'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * @return BelongsTo
     */
    public function whence(): BelongsTo
    {
        return $this->belongsTo(Whence::class);
    }

    /**
     * @param $value
     * @return void
     */
    public function setBuydayAttribute($value)
    {
        $this->attributes['buyday'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    /**
     * @param $value
     * @return string
     */
    public function getBuydayAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
    }

    public function setLegal1Attribute($value)
    {
        $this->attributes['legal_1'] = $value === 'on';
    }

    public function setLegal2Attribute($value)
    {
        $this->attributes['legal_2'] = $value === 'on';
    }

    public function setLegal3Attribute($value)
    {
        $this->attributes['legal_3'] = $value === 'on';
    }

    public function setLegal4Attribute($value)
    {
        $this->attributes['legal_4'] = $value === 'on';
    }

    public function setLegal5Attribute($value)
    {
        $this->attributes['legal_5'] = $value === 'on';
    }

}
