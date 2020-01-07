<?php

namespace App\Models\Backend\User;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function users()
    {
        return $this->hasMany('App\Models\Backend\User');
    }

    public function is($status)
    {
        return $this->name == $status;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];    
}
