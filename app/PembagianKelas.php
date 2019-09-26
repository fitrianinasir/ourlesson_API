<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembagianKelas extends Model
{
    protected $primaryKey = 'class_id';
    protected $fillable = [
        'date',
        'time',
        'subject',
        'class',
    ];
}
