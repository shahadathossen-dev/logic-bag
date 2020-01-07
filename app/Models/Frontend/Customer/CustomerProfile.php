<?php

namespace App\Models\Frontend\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    
	public function owner()
	{
        return $this->belongsTo('App\Models\Frontend\Customer');
	}

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'custimer_id', 'fname', 'lname', 'phone', 'street_address', 'union', 'city', 'zipcode', 'country'
    ];

}
