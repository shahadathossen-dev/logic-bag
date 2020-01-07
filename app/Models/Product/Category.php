<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function subcategories()
    {
        return $this->hasMany('App\Models\Product\Subcategory');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
    
    // Route Model Binding
    public function getRouteKeyName()
    {
        return 'title';
    }

    // public $primaryKey = ['id', 'title'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];
}
