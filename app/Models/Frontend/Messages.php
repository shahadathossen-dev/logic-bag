<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Messages extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('descending', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    protected $table = 'messages';

    public function customer()
    {
        return $this->belongsTo('App\Models\Frontend\Customer');
    }

    public function visitor()
    {
        return $this->belongsTo('App\Models\Frontend\Visitor');
    }

    public function user ()
    {
        if ($this->customer()->exists()) {
            return $this->customer();
        } else {
            return $this->visitor();
        }
    }

    public function isReviewed()
    {
        return $this->reviewed === 1;
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Frontend\Messages\Replies', 'message_id', 'ticket');
    }

    public function replies_paginate()
    {
        return $this->hasMany('App\Models\Frontend\Messages\Replies', 'message_id', 'ticket')->paginate(5);
    }

    protected $fillable = [
        'ticket', 'customer_id', 'visitor_id', 'subject', 'message', 'reviewed', 'reviewed_by'
    ]; 
}
