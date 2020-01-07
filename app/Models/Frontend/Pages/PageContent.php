<?php

namespace App\Models\Frontend\Pages;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{


    protected $fillable = [
        'page', 'content', 
    ];
}
