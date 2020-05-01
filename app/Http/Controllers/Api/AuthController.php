<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Storage;
// use League\Flysystem\File;
use Symfony\Component\HttpFoundation\File\File;
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
        'image'=>'',
        'password'=>'required',
      ]);

      if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $original_name= $request->file('image')->getClientOriginalName(); 
        $request->file('image')->storeAs('public/uploads', $original_name );
        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $user->image = $original_name;
        $user->save();
        $accessToken = $user->createToken('authToken')->accessToken;
        $response = ['user'=>[$user], 'access_token'=>$accessToken];
        return response([$response]);
      } else{
        return response()->json(array('status'=>'error','message'=>'failed to upload image'));
      }

    // if($request->hasFile('image')){

    //     $uniqueid=uniqid();
    //     $original_name= $request->file('image')->getClientOriginalName(); 
    //     $size = $request->file('image')->getSize();
    //     $extension=$request->file('image')->getClientOriginalExtension();

    //     $name=$uniqueid.'.'.$extension;
    //     $path=$request->file('image')->storeAs('public/uploads',$name);
    //     if($path){
    //       $validatedData['password'] = bcrypt($request->password);

    //       $user = User::create($validatedData);
    //       $user->image = $original_name;
    //       $user->save();
    
    //       $accessToken = $user->createToken('authToken')->accessToken;
    //       $response = ['user'=>[$user], 'access_token'=>$accessToken];
    //       return response([$response], 200);
    //       // return response()->json(array('status'=>'success','message'=>'Image successfully uploaded','image'=>'/storage/uploads/'.$name));
    //     }else{
    //         return response()->json(array('status'=>'error','message'=>'failed to upload image'));
    //     }
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
      $user = User::findOrFail($id);
      $input = $request->all();
      if($request->hasFile('image')){
        if($request->file('image')->isValid()){
          $removeImg = str_replace('/storage', '', $user->image);
          Storage::delete('/public/uploads/'.$removeImg);
          $image_name = $request->file('image')->getClientOriginalName();
          $request->file('image')->storeAs('public/uploads', $image_name );
          $input['image'] = $image_name;
        }
      }
        $user->update($input);
        $user->nis = $request->nis;
        $user->student_name = $request->student_name;
        $user->birthplace = $request->birthplace;
        $user->birthdate = $request->birthdate;
        $user->address = $request->address;
        $user->religion = $request->religion;
        $user->gender = $request->gender;
        $user->student_class = $request->student_class;
        $user->schools = $request->schools;
        $user->year = $request->year;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = bcrypt($request->password);
        $user->save();
        return ['success' => 'Update successfully', 'user' => $user];
      


    //   $student = User::findOrFail($id);
    //   // $student->update($request->all());
    //   if ($request->hasfile('image')){
    //     $file = $request->file('image');
    //     $extension = $file->getClientOriginalExtension();
    //     $filename = md5(time()).'.'.$extension;
    //     $file->move('public/uploads',$filename);
    //     $student->image=$filename;
    //     $student->nis = $request->nis;
    //     $student->student_name = $request->student_name;
    //     $student->birthplace = $request->birthplace;
    //     $student->birthdate = $request->birthdate;
    //     $student->address = $request->address;
    //     $student->religion = $request->religion;
    //     $student->gender = $request->gender;
    //     $student->student_class = $request->student_class;
    //     $student->schools = $request->schools;
    //     $student->year = $request->year;
    //     $student->email = $request->email;
    //     $student->phone_number = $request->phone_number;
    //     $student->password = $request->password;
    //     $student->save();
    //     return ['success' => 'Update successfully', 'user' => $student];
    // }
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
        $data = User::find($id);
        $removeImg = str_replace('/storage', '', $data->image);
        Storage::delete('/public/uploads/'.$removeImg);
        $data->delete();
        return 'Data deleted successfully';
    }
}
