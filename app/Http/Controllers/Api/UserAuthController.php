<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAuthController extends Controller
{
    public $successStatus = 200;
    public function login(Request $request){
        $loginData = $request->validate([
          'nis'=>'required',
          'password'=>'required'
        ]);
        if(!auth()->attempt($loginData)){
          return response(['message' => 'Invalid credentials']);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user'=> auth()->user(), 'access_token'=> $accessToken]);
      }
}
