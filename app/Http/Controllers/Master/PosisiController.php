<?php

namespace App\Http\Controllers\Master;

use App\Models\Posisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PosisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Posisi::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'posisi' => 'required',
            'hak_akses' => 'required'
        ]);

        if($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $posisi = Posisi::create($validator->validated());
        return response()->json(['msg' => 'Data berhasil ditambahakan', 'data' => $posisi]);
    }

    /**
     * Display the specified resource.
     */
    public function show($posisi)
    {
        $data = Posisi::find($posisi);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        return response()->json($data,200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $posisi)
    {
        $data = Posisi::find($posisi);
        if(!$posisi)  return response()->json(['msg' => 'Data tidak ditemukan'],404);

        $validator = Validator::make($request->all(), [
            'posisi' => 'required',
            'hak_akses' => 'required'
        ]);

        if($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data->update($validator->validated());
        return response()->json(['msg' => 'Data berhasil diubah'],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($posisi)
    {
        $data = Posisi::find($posisi);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'],404);

        $data->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'],200);
    }
}
