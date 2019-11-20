<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $successStatus = 200;
    public function register(Request $request){
      
     
      // return response()->json("data berhasil masuk", compact('path'));
      $validatedData = $request->validate([
        'nis'=>'required|unique:users',
        'student_name'=>'required|max:55',
        'birthplace'=>'required',
        'birthdate'=>'required',
        'address' => 'required',
        'religion'=>'required',
        'schools'=>'required',
        'gender'=>'required',
        'email'=>'required',
        'phone_number'=> 'required',
        'year'=>'required',
        'student_class'=>'required',
        'password'=>'required',
        'image'=>'required'
      ]);

      if(!$request->hasFile('image')) {
        return response()->json(['upload_file_not_found'], 400);
      }
      $file = $request->file('image');
      if(!$file->isValid()) {
          return response()->json(['invalid_file_upload'], 400);
      }
      $path = public_path();
      $file->move($path, $file->getClientOriginalName());
      $file_name = $file->getClientOriginalName();

      $validatedData['password'] = bcrypt($request->password);

      $user = User::create($validatedData);
      $user->image = $file_name;
      $user->save();

      $accessToken = $user->createToken('authToken')->accessToken;
      $response = ['user'=>[$user], 'access_token'=>$accessToken];
      return response([$response], 200);
    }

    public function login(Request $request){
      $user = User::where('nis', $request->nis)->first();
      if ($user) {
          if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['user'=>$user, 'token' => $token];
            return response([$response], 200);
          } else {
            $response = "Password missmatch";
            return response($response, 422);
          }
  
      } else {
          $response = 'User does not exist';
          return response($response, 422);
      }
      // return $user;
    }

    public function details() 
    { 
        $user = User::all(); 
        return $user;
        // return response()->json(['success' => $user], $this->successStatus); 
    } 
    public function show($id)
    {
      return [User::find($id)];

    }

    public function downloadimage($id){
      $data = User::find($id);
      $file_name = $data->image;
      $file_path = public_path(). "/uploads/".$file_name;
      return response()->download($file_path);
    }
    public function update(Request $request, $id)
    {
      $student = User::findOrFail($id);
      $student->update($request->all());

      return [$student];
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
        $data=User::find($id);
        $data->delete();
        return 'Data deleted successfully';
    }
}
