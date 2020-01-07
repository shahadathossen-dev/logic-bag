<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    // Route Model Binding
    public function getRouteKeyName()
    {
        return 'offer_id';
    }

	public function item () 
	{
		return $this->hasOne('App\Models\Product', 'model', 'model');
	}

    protected $fillable = [
        'offer_id', 'name', 'model', 'discount', 'expiry_date', 'sales',
    ];
}
