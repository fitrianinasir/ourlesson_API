<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaftarTutor extends Model
{
    protected $fillable = [
        'tutor_name',
        'tutor_subject',
        'background',
        'phone_number',
        'email'
    ];
}
