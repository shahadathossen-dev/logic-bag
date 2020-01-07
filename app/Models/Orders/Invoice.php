<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    public function getRouteKeyName()
    {
        return 'invoice_number';
    }

    public function order ()
    {
        return $this->belongsTo('App\Models\Order', 'order_number', 'order_number');
    }

    public function billingAddress()
    {
        return $this->order()->billingAddress();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_number', 'order_number', 'bill', 'payment', 'paid'
    ];
}
