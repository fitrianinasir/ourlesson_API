<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DaftarTutor;
use Illuminate\Support\Facades\Validator;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutors = DaftarTutor::all();
        return response()->json($tutors,200);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'tutor_name' => 'required',
            'tutor_subject' => 'required',
            'background' => 'required',
            'phone_number' => 'required',
            'email' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'data' => 'Validation error',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $tutor = DaftarTutor::create($input);

        return [$tutor];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tutor = DaftarTutor::find($id);
        $data = $tutor->toArray();

        if(is_null($tutor)){
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Tutor not found'
            ];
        return response()->json($response, 404);
        }
        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Tutor retrieved successfully.'
        ];

        return response()->json([$response], 200);
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
        $tutor=DaftarTutor::find($id);
        $tutor->tutor_name=$request->tutor_name;
        $tutor->tutor_subject=$request->tutor_subject;
        $tutor->background = $request->background;
        $tutor->email=$request->email;
        $tutor->phone_number=$request->phone_number;
        $tutor->save();
        
        $response = [
         'success' => true,
         'data' => $tutor,
         'message' => 'Tutor updated successfully.'
     ];
 
     return response()->json([$response], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=DaftarTutor::find($id);
        $data->delete();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Tutor deleted successfully.'
        ];

        return response()->json([$response], 200);
    }
}
