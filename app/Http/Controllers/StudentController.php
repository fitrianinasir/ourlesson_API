<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DaftarSiswa;
use DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = DaftarSiswa::all();
        return $student;
    }

    public function getUsers(Request $request){
        $users = DB::table('users')->get();
        return $users;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = new DaftarSiswa;
        $student->nis = $request->input('nis');
        $student->student_name = $request->input('student_name');
        $student->birthplace = $request->input('birthplace');
        $student->birthdate = $request->input('birthdate');
        $student->address = $request->input('address');
        $student->religion = $request->input('religion');
        $student->gender = $request->input('gender');
        $student->school = $request->input('school');
        $student->email = $request->input('email');
        $student->phone_number = $request->input('phone_number');
        $student->save();
        
        // return "Data Berhasil Masuk";
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = DaftarSiswa::find($id);
        if($student){
            return new DaftarSiswa($student);
        }else{
            return "Student not found";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nis = $request->nis;
        $student_name = $request->student_name;
        $birthplace = $request->birthplace;
        $birthdate = $request->birthdate;
        $address = $request->address;
        $religion = $request->religion;
        $school = $request->school;
        $email = $request->email;
        $phone_number = $request->phone_number;

        $student = DaftarSiswa::find($id);
        $student->nis = $nis;
        $student->student_name = $student_name;
        $student->birthplace = $birthplace;
        $student->birthdate = $birthdate;
        $student->address = $address;
        $student->religion = $religion;
        $student->school = $school;
        $student->email = $email;
        $student->phone_number = $phone_number;
        $student->save();
        return "Data Berhasil Diupdate";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = DaftarSiswa::findOrfail($id);
        $student->delete();
        return "Data Berhasil Dihapus";
    }
}
