<?php

namespace App\Http\Controllers\Master;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Lokasi::all(),200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_lokasi' => 'required|unique:lokasis,nama_lokasi'
        ]);

        if($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $lokasi = new Lokasi;
        $lokasi->nama_lokasi =  $request->input('nama_lokasi');

        $lokasi->save();

        return response(['msg' => 'Data ditambahkan', 'data' => $lokasi], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($lokasi)
    {
        $data = Lokasi::find($lokasi);

        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $lokasi)
    {
        $data = Lokasi::find($lokasi);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $validator = Validator::make($request->all(),[
            'nama_lokasi' => ['required', Rule::unique('lokasis','nama_lokasi')->where(function($q) use ($data){
                return $q->where('nama_lokasi', '!=', $data->nama_lokasi);
            })]
        ]);

        if($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data->nama_lokasi = $request->input('nama_lokasi');
        $data->save();

        return response()->json(['msg' => 'Data berhasil diubah'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lokasi)
    {
        $data = Lokasi::find($lokasi);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $data->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'],200);
    }
}
