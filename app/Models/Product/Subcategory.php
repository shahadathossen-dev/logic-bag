<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
	/**
     * Get the comments for the blog post.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Product\Category');
    }

    public function category_by_id($id)
    {
        $category = $this->category->where('id', $id);
        return $category;
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
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'title',
    ];
}
