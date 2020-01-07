<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'model', 'model');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model', 'discount'
    ];
}
