<?php

namespace App\Http\Controllers\Master;

use App\Models\Rak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Rak::all(),200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'lokasi_id' => 'required',
            'rak' => 'required|unique:raks,rak'
        ]);

        if($validator->fails()){
            return response()->json(['errors', $validator->errors()],422);
        }

        $rak = new Rak;
        $rak->lokasi_id = $request->input('lokasi_id');
        $rak->rak = $request->input('rak');
        $rak->save();

        $response = [
            'msg' => 'Data berhasil dibuat',
            'data' => $rak
        ];

        return response()->json($response,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rak $rak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rak $rak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rak $rak)
    {
        //
    }
}
