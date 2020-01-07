<?php

namespace App\Models\Product\Review;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Reply extends Model
{
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('descending', function (Builder $builder) {
    //         $builder->orderBy('created_at', 'desc');
    //     });
    // }

    static function scopeApproved($query)
    {
      if ($query) $query->where('approved', 1);
    }

	public function review()
	{
        return $this->belongsTo('App\Models\Product\Review');
	}

	public function customer()
	{
        return $this->belongsTo('App\Models\Frontend\Customer');
	}

	public function user()
	{
        return $this->belongsTo('App\Models\Backend\User');
	}

    public function replier()
    {
        if($this->customer()->exists()){
            return $this->customer();
        }

        return $this->user();
    }

    public function isApproved()
    {
        return $this->approved === 1;
    }

    public function isReviewed()
    {
        return $this->reviewed === 1;
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review_id', 'customer_id', 'user_id', 'comment', 'approved', 'reviewed'
    ];    
}
