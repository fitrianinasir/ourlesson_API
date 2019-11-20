<?php

use App\Http\Controllers\TutorController;
use Illuminate\Http\Request;

// USER AUTHENTICATION
Route::post('/user-login', 'Api\AuthController@login');

Route::middleware('auth:api')->group( function () {
  Route::get('/student-details', 'Api\AuthController@details');
  Route::get('/tutors', 'TutorController@index');
  Route::post('/logout', 'Api\AuthController@logout');
  Route::get('classes','KelasController@index');
  
});

// ADMIN AUTHENTICATION & MIDDLEWARE
Route::post('/admin-register', 'Api\AdminAuthController@register');
Route::post('/admin-login', 'Api\AdminAuthController@login');


Route::get('/downloadimage/{id}', 'Api\AuthController@downloadimage');  
Route::middleware('auth:admin')->group(function(){
  // USER CONTROLLER
  Route::post('/register', 'Api\AuthController@register');  
  Route::get('/details', 'Api\AuthController@details');
  Route::get('/detail/{id}', 'Api\AuthController@show');
  Route::put('/student-update/{id}', 'Api\AuthController@update');
  Route::delete('/remove/{id}', 'Api\AuthController@destroy');

  // TUTOR CONTROLLER
  Route::get('/daftar-tutor', 'TutorController@index');
  Route::get('/tutor/{id}', 'TutorController@show');
  Route::post('/create-tutor', 'TutorController@store');
  Route::post('/tutor/{id}', 'TutorController@update');
  Route::delete('/remove-tutor/{id}', 'TutorController@destroy');

  // SCHEDULE CONTROLLER 
  Route::get('admin-classes','KelasController@index');
  Route::get('class/{id}','KelasController@show');
  Route::post('/class', 'KelasController@store');
  Route::put('class/{id}','KelasController@update');
  Route::delete('class/{id}','KelasController@destroy');
  
  // LOGOUT ADMIN
  Route::post('/admin-logout', 'Api\AdminAuthController@logout');
});

// USER CRUD



// USER UNUSED FOR AWHILE
Route::get('students', 'StudentController@index');
Route::get('student/{id}', 'StudentController@show');
Route::post('student', 'StudentController@store');
Route::put('student/{id}', 'StudentController@update');
Route::delete('student/{id}', 'StudentController@destroy');
Route::get('/users', 'Api\StudentController@getUsers'); 