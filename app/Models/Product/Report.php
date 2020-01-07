<?php

namespace App\Models\Product;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    // Route Model Binding
    public function getRouteKeyName()
    {
        return 'model';
    }
    
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
        'model', 'sales', 'revenue'
    ];
}
