<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
	public static function boot()
    {
        parent::boot();

        // Generate slug before saving Model
        static::saving(function ($model) {

        });

        // create a event to happen on updating
        static::updating(function($model){

        });

    }

    static function scopePublished($query)
    {
        if ($query) $query->where('published', 1);
    }

    // Route Model Binding
    public function getRouteKeyName()
    {
        return 'model';
    }
    
    protected $touches = ['product'];

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
        'model', 'title', 'slug', 'description', 'reviewed', 'published', 'views', 'last_view', 'created_by', 'updated_by'
    ];
}
