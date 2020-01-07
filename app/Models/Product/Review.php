<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('descending', function (Builder $builder) {
        //     $builder->orderBy('created_at', 'desc');
        // });

        // create a event to happen on deleting
        static::deleting(function($model){
            // $model->allReplies()->forceDelete();
        });
    }

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    static function scopeApproved($query)
    {
      if ($query) $query->where('approved', 1);
    }

	public function product()
	{
        return $this->belongsTo('App\Models\Product');
	}

	public function customer()
    {
        return $this->belongsTo('App\Models\Frontend\Customer');
    }

    public function visitor()
    {
        return $this->belongsTo('App\Models\Frontend\Visitor');
    }

    public function reviewer()
    {

        if($this->customer()->exists()){
            return $this->customer();
        }

        return $this->visitor();

    }

    public function isApproved()
    {
        return $this->approved === 1;
    }

    public function isReviewed()
    {
        return $this->reviewed === 1;
    }

    // public function approved()
    // {
    //     return $this->where('approved', 1)->exists();
    // }

    public function replies()
    {
        return $this->hasMany('App\Models\Product\Review\Reply')->approved();
    }

    public function allReplies()
    {
        return $this->hasMany('App\Models\Product\Review\Reply');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'customer_id', 'visitor_id', 'comment', 'rating', 'approved', 'reviewed', 'updated_by'
    ];
}
