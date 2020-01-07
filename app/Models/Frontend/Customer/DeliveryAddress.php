<?php

namespace App\Models\Frontend\Customer;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    public function customer ()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function order ()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function name()
    {
        return $this->fname.' '.$this->lname;
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'fname', 'lname', 'email', 'phone', 'street_address', 'union', 'city', 'zipcode', 'country', 
    ];
}
