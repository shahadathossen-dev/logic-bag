<?php

namespace App\Models\Frontend\Messages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Replies extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('descending', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    protected $table = 'message_replies';

	public function message()
	{
        return $this->belongsTo('App\Models\Frontend\Messages', 'message_id', 'ticket');
	}

    public function replier()
    {
        return $this->belongsTo('App\Models\Backend\User', 'user_id', 'id');
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id', 'user_id', 'reply', 
    ];    
}
