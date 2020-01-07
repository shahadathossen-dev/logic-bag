<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function order ()
    {
        return $this->belongsTo('App\Models\Order', 'order_number', 'order_number');
    }

    public function variant ()
    {
        return $this->hasOne('App\Models\Product\Attribute', 'sku', 'attribute');
    }

    public function product ()
    {
        return $this->hasOne('App\Models\Product', 'model', 'model');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number', 'model', 'attribute', 'quantity', 'price', 'total', 
    ];
}
