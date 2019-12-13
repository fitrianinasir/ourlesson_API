<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Handbooks;
use Illuminate\Support\Facades\Storage;

class HandbooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $handbooks = Handbooks::all();
        return $handbooks;
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
      $validatedData = $request->validate([
        'title'=>'required',
        'file'=>'required|mimes:pdf|max:5000',
      ]);
      if ($request->hasFile('file') && $request->file('file')->isValid()) {
        $original_name= $request->file('file')->getClientOriginalName(); 
        $request->file('file')->storeAs('public/file', $original_name );
        $file = Handbooks::create($validatedData);
        $file->file = $original_name;
        $file->save();
        $response = ['file'=>[$file]];
        return response([$response]);
      } else{
        return response()->json(array('status'=>'error','message'=>'failed to upload image'));
      }
    }

    /**
     * Display the specified resource.
     *  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return [Handbooks::find($id)];
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
        $file = Handbooks::findOrFail($id);
        $input = $request->all();
        if($request->hasFile('file')){
          if($request->file('file')->isValid()){
            $removeFile = str_replace('/storage', '', $file->file);
            Storage::delete('/public/file/'.$removeFile);
            $file_name = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('/public/file', $file_name);
            $input['file'] = $file_name;
          }
        }
        $file->update($input);
        $file->title = $request->title;
        $file->save();
        return ['success' => 'Update Successfully', 'data' => $file];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Handbooks::find($id);
        $removeFile = str_replace('storage', '', $data->file);
        Storage::delete('public/file/'.$removeFile);
        $data->delete();
        return ['message' => 'Handbook deleted successfully'];
    }
}
