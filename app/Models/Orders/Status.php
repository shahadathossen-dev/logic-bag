<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'order_statuses';
    
    public function order()
    {
        return $this->hasMany('App\Models\Orders');
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
