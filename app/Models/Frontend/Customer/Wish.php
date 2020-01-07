<?php

namespace App\Models\Frontend\Customer;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{

	public function customer()
	{
		return $this->belongsTo('App\Models\Frontend\Customer');
	}

	public function product()
	{
		return $this->hasOne('App\Models\Product', 'model', 'model');
	}

    protected $fillable = [
	        'customer_id', 'model', 'attribute'
	    ];
}
