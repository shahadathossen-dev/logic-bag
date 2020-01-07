<?php

namespace App\Models\Frontend\Pages;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
	public function item () 
	{
		return $this->hasOne('App\Models\Product', 'model', 'model');
	}

    protected $fillable = [
        'model', 'banner', 
    ];
}
