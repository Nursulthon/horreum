<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'about',
        'price',
        'category_id',
        'is_popular',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_products')
            ->withPivot('stock')
            ->withTimestamps();
    }

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_products')
            ->withPivot('stock')
            ->withTimestamps();
    }

    public function transaction()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function getWarehouseProductStock()
    {
        return $this->warehouses()->sum('stock');
    }

    public function getMerchantProductStock()
    {
        return $this->merchants()->sum('stock');
    }

    public function getThumbnailUrlAttribute($value)
    {
        if (!$value)
            {
                return null;
            }

        return url(Storage::url($value));
    }
}
