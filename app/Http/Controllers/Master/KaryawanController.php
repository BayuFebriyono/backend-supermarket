<?php

namespace App\Http\Controllers\Master;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(Karyawan::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:karyawans,nama',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }



        $karyawan = new Karyawan;
        $karyawan->nama = $request->input('nama');
        $karyawan->alamat = $request->input('alamat');
        $karyawan->tempat_lahir = $request->input('tempat_lahir');
        $karyawan->tanggal_lahir = $request->input('tanggal_lahir');
        $karyawan->no_hp = $request->input('no_hp');
        $karyawan->tanggal_gabung = now();
        $karyawan->save();

        $response = [
            'msg' => 'Sukses ditambahkan',
            'data' => $karyawan
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($karyawan)
    {
        $data = Karyawan::find($karyawan);
        if ($data) return response($data);

        return response(['msg' => 'Data tidak ditemukan'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $karyawan)
    {
        $data = Karyawan::find($karyawan);
        if (!$data) return response(['msg' => 'Data tidak ditemukan'], 404);
        $validator = Validator::make($request->all(), [
            'nama' => [Rule::unique('karyawans', 'nama')->where(function ($q) use ($data) {
                return $q->where('nama', '!=', $data->nama);
            })],
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data->nama = $request->input('nama');
        $data->alamat = $request->input('alamat');
        $data->tempat_lahir = $request->input('tempat_lahir');
        $data->tanggal_lahir = $request->input('tanggal_lahir');
        $data->no_hp = $request->input('no_hp');
        $data->save();

        return response()->json(['msg' => 'Data berhasil diperbarui'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($karyawan)
    {
        $data = Karyawan::find($karyawan);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $data->delete();

        return response()->json(['Data berhasil dihapus'], 200);
    }
}
