<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handbooks extends Model
{
    protected $fillable = [
        'title', 
        'file', 
    ];
}
