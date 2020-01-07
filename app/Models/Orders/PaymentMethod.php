<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
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
        'mode', 'description'
    ];    
}
