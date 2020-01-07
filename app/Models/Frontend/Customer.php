<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public function profile()
    {
        return $this->hasOne('App\Models\Frontend\Customer\CustomerProfile');
    }

    public function billingAddresses()
    {
        return $this->hasMany('App\Models\Frontend\Customer\BillingAddress');
    }

    public function deliveryAddresses()
    {
        return $this->hasMany('App\Models\Frontend\Customer\DeliveryAddress');
    }

    public function wishes()
    {
        return $this->hasMany('App\Models\Frontend\Customer\Wish');
    }

    public function wish($product, $sku)
    {
        // return $this->hasOne('App\Models\Frontend\Customer\Wish')->where('product_id', $product)->whereAttribute($sku)->first();
        return $this->hasOne('App\Models\Frontend\Customer\Wish')->whereModel($product)->whereAttribute($sku);
    }

    public function hasWish($product, $sku)
    {
        return $this->wish($product, $sku)->exists();
    }

    public function hasOrder($order)
    {
        return $this->orders()->where('order_number', $order)->exists();
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Product\Review');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Product\Review\Reply');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function fullname()
    {
        return $this->fname.' '.$this->lname;
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'password', 'email_verified_at', 'subscribe', 'dob', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
