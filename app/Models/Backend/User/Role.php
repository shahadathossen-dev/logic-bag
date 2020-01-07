<?php

namespace App\Models\Backend\User;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->hasMany('App\Models\Backend\User');
    }

    public function is($role)
    {
        return $this->name == $role;
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
