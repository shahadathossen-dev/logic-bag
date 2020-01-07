<?php

namespace App\Models\Frontend\Pages;

use Illuminate\Database\Eloquent\Model;

class TradeMarks extends Model
{


    protected $table = 'trade_marks';

    protected $fillable = [
        'type', 'content', 
    ];
}
