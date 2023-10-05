<?php

namespace App\Http\Controllers\Master;

use App\Models\Rak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    public function show($rak)
    {
        $data = Rak::find($rak);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 400);

        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $rak)
    {
        $data = Rak::find($rak);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 400);

        $validator = Validator::make($request->all(),[
            'lokasi_id' => 'required',
            'rak' => ['required', Rule::unique('raks', 'rak')->where(function ($q) use ($data){
                return $q->where('rak', '!=' , $data->rak);
            })]
        ]);

        if($validator->fails()){
            return response()->json(['errors', $validator->errors()],422);
        }

        $data->lokasi_id = $request->input('lokasi_id');
        $data->rak = $request->input('rak');
        $data->save();

        return response()->json(['msg' => 'Data berhasil diubah'],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $rak)
    {
        $data = Rak::find($rak);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 400);

        $data->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'],200);
    }
}
