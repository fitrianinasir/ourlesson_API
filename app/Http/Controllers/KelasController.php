<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PembagianKelas;

class KelasController extends Controller
{
    public function index()
    {
        $classes = PembagianKelas::all();

        // $response = [
        //     'success' => true,
        //     'data' => $classes,
        //     'msg'=>'class accepted',
        //     'message' => 'Classes retrieved successfully.'
        // ];

        return response()->json($classes, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'date' => 'required',
            'time' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $class = PembagianKelas::create($input);
        $data = $class->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Class stored successfully.'
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $class = PembagianKelas::find($id);
        $data = $class->toArray();

        if (is_null($class)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Class not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Class retrieved successfully.'
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
       $classes=PembagianKelas::find($id);
       $classes->date=$request->date;
       $classes->tutor=$request->tutor;
       $classes->time=$request->time;
       $classes->subject=$request->subject;
       $classes->class=$request->class;
       $classes->save();
       
       $response = [
        'success' => true,
        'data' => $classes,
        'message' => 'Class updated successfully.'
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
        
        $data=PembagianKelas::find($id);
        $data->delete();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Class deleted successfully.'
        ];

        return response()->json([$response], 200);
    }
}
