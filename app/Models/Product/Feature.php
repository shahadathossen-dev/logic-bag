<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
