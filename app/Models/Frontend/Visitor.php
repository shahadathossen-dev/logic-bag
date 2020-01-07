<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    public function reviews ()
    {
        return $this->hasMany('App\Models\Product\Review');
    }

    public function messages ()
    {
        return $this->hasMany('App\Models\Frontend\Messages');
    }

    public function fullname()
    {
        return $this->name;
    }

    protected $fillable = [
    	'name', 'email', 'avatar'
    ]; 
}
