<?php

namespace App\Http\Controllers\Api;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;

class AdminAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $successStatus = 200;
    public function register(Request $request){
      $validatedData = $request->validate([
                      'username'=>'required',
                      'password'=>'required'
                    ]);
      $validatedData['password'] = bcrypt($request->password);
      $admin = Admin::create($validatedData);
      $accessToken = $admin->createToken('authToken')->accessToken;
      return response(['admin'=>$admin, 'access_token'=>$accessToken]);
    }

    public function login(Request $request){
      $admin = Admin::where('username', $request->username)->first();

      if ($admin) {
          if (Hash::check($request->password, $admin->password)) {
              $token = $admin->createToken('Laravel Password Grant Client')->accessToken;
              $response = ['admin'=>$admin, 'token' => $token];
              return response([$response], 200);
          } else {
              $response = "Password missmatch";
              return response($response, 422);
          }
  
      } else {
          $response = 'User does not exist';
          return response($response, 422);
      }
      return $admin;
    }


    public function details() 
    { 
        $user = Admin::all(); 
        return $user;
        // return response()->json(['success' => $user], $this->successStatus); 
    } 

    public function logout(Request $request){
      $value = $request->bearerToken();
      $id = (new Parser())->parse($value)->getHeader('jti');
      $token=$request->user()->tokens()->find($id);
      $token->revoke();
      $response = 'You have been successfully logged out';
      return response($response, 200);
    }

    public function destroy($id)
    {
        // $request->user()->token()->revoke();
        // return response()->json([
        //     'message' => 'Successfully logged out'
        // ]);
        $data=Admin::find($id);
        $data->delete();
        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'User deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
