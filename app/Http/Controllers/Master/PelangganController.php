<?php

namespace App\Http\Controllers\Master;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Pelanggan::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:pelanggans,nama',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required|numeric',
            'poin' => 'numeric'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $pelanggan = new Pelanggan;
        $pelanggan->nama = $request->input('nama');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->tempat_lahir = $request->input('tempat_lahir');
        $pelanggan->tanggal_lahir = $request->input('tanggal_lahir');
        $pelanggan->no_hp = $request->input('no_hp');
        $pelanggan->poin = $request->input('poin') ?? null;
        $pelanggan->save();

        return response()->json($pelanggan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($pelanggan)
    {
        $data = Pelanggan::find($pelanggan);
        if (!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $pelanggan)
    {
        $data = Pelanggan::find($pelanggan);
        if (!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $validator = Validator::make($request->all(), [
            'nama' => ['required', Rule::unique('pelanggans', 'nama')->where(function ($q) use ($data) {
                return $q->where('nama', '!=', $data->nama);
            })],
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required|numeric',
            'poin' => 'numeric'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        $data->nama = $request->input('nama');
        $data->alamat = $request->input('alamat');
        $data->tempat_lahir = $request->input('tempat_lahir');
        $data->tanggal_lahir = $request->input('tanggal_lahir');
        $data->no_hp = $request->input('no_hp');
        $data->poin = $request->input('poin') ?? null;
        $data->save();

        return response()->json(['msg' => 'Data berhasil diubah'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($pelanggan)
    {
        $data = Pelanggan::find($pelanggan);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'],404);

        $data->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'],200);
    }
}
