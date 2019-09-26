<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ADMIN AUTH
Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::post('/logout', 'Api\AuthController@logout');

Route::middleware('auth:api')->group( function () {
  Route::get('students', 'StudentController@index');
  Route::get('student/{id}', 'StudentController@show');
  Route::post('student', 'StudentController@store');
  Route::put('student/{id}', 'StudentController@update');
  Route::delete('student/{id}', 'StudentController@destroy');

  Route::get('/users', 'Api\StudentController@getUsers');
  Route::get('/details', 'Api\AuthController@details');

  Route::get('classes','KelasController@index');
  Route::get('classes/{id}','KelasController@show');
  Route::post('class','KelasController@store');
  Route::put('class/{id}','KelasController@update');
  Route::delete('class/{id}','KelasController@destroy');
  Route::delete('/remove/{id}', 'Api\AuthController@destroy');
  // Route::resource('classes', 'KelasController');

});

// USER AUTH
Route::post('/userlogin', 'Api\UserAuthController@login');

Route::middleware('auth:admin')->group(function(){
    //All the user routes will be defined here...
    Route::get('classes','KelasController@index');
    Route::get('classes/{id}','KelasController@show');
});

