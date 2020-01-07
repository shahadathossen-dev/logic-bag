<?php

namespace App\Models\Backend\User;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    public function user()
    {
        return $this->belongsTo('App\Models\Backend\User');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id', 'dob', 'phone', 'education', 'address', 'skills', 'notes', 'avatar'
    ];

}
