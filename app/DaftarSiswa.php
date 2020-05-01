<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaftarSiswa extends Model
{
    protected $fillable = [
        'nis', 
        'student_name', 
        'birthplace', 
        'birthdate', 
        'address', 
        'religion', 
        'school', 
        'gender', 
        'email', 
        'phone_number',
        
    ];
}
