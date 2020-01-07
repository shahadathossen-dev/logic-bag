<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $casts = [
        'images' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'sku';
    }

    public function product()
    {
    	return $this->belongsTo('App\Models\Product');
    }

    public function isAvailable($quantity)
    {
        return $this->stock > $quantity;
    }

    public function stock()
    {
        return $this->stock;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'sku', 'color', 'stock', 'images', 'meta_color'
    ];
}
