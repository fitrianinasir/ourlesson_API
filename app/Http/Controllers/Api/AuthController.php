<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $successStatus = 200;
    public function register(Request $request){
      $validatedData = $request->validate([
                      'nis'=>'required|unique:users',
                      'name'=>'required|max:55',
                      'password'=>'required'
                    ]);
      $validatedData['password'] = bcrypt($request->password);
      $user = User::create($validatedData);
      $accessToken = $user->createToken('authToken')->accessToken;
      return response(['user'=>$user, 'access_token'=>$accessToken]);
    }

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


    public function details() 
    { 
        $user = User::all(); 
        return $user;
        // return response()->json(['success' => $user], $this->successStatus); 
    } 

    public function destroy($id)
    {
        // $request->user()->token()->revoke();
        // return response()->json([
        //     'message' => 'Successfully logged out'
        // ]);
        $data=User::find($id);
        $data->delete();
        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'User deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
