<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


    // Route Model Binding
    public function getRouteKeyName()
    {
        return 'order_number';
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Frontend\Customer');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Orders\Status');
    }

    public function items ()
    {
        return $this->hasMany('App\Models\Orders\OrderItem', 'order_number', 'order_number');
    }

    public function billingAddress()
    {
        return $this->belongsTo('App\Models\Frontend\Customer\BillingAddress');
    }

    public function deliveryAddress()
    {
        return $this->belongsTo('App\Models\Frontend\Customer\DeliveryAddress');
    }
    
    public function invoice ()
    {
        return $this->hasOne('App\Models\Orders\Invoice', 'order_number', 'order_number');
    }

    public function paymentMode()
    {
        return $this->belongsTo('App\Models\Orders\PaymentMethod', 'payment_mode', 'id');
    }

    public function isCancellable ()
    {
        $orderTime = $this->created_at;
        $now = Carbon::now();
        $diff = $now->diffInHours($orderTime);

        if ($this->status_id == 1 && $diff < 24 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'order_number', 'billing_address_id', 'delivery_address_id', 'payment_mode', 'delivery_date', 'status_id', 'note'
    ];
}
