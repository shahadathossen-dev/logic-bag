<?php

namespace App\Models\Frontend\Pages;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
	public function item () 
	{
		return $this->hasOne('App\Models\Product', 'model', 'model');
	}

    protected $fillable = [
        'model', 'image', 
    ];
}
