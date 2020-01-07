<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // Route Model Binding
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
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
