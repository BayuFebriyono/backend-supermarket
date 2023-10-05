<?php

namespace App\Http\Controllers\Master;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Barang::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'rak_id' => 'required',
            'nama_barang' => 'required|unique:barangs,nama_barang',
            'satuan' => 'required|',
            'harga' => 'numeric|required',
            'stock' => 'numeric|required',
            'catatan' => 'required',
            'diskon' => 'numeric'
        ]);

        if($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $barang = new Barang;
        $barang->rak_id = $request->input('rak_id');
        $barang->nama_barang = $request->input('nama_barang');
        $barang->satuan = $request->input('satuan');
        $barang->harga = $request->input('harga');
        $barang->stock = $request->input('stock');
        $barang->catatan = $request->input('catatan');
        $barang->diskon = $request->input('diskon') ?? null;
        $barang->save();

        return response()->json($barang,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($barang)
    {
        $data = Barang::find($barang);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $barang)
    {
        $data = Barang::find($barang);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $validator = Validator::make($request->all(),[
            'rak_id' => 'required',
            'nama_barang' => ['required', Rule::unique('barangs', 'nama_barang')->where(function ($q) use ($data){
                return $q->where('nama_barang' , '!=' , $data->nama_barang);
            })],
            'satuan' => 'required|',
            'harga' => 'numeric|required',
            'stock' => 'numeric|required',
            'catatan' => 'required',
            'diskon' => 'numeric'
        ]);

        if($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data->rak_id = $request->input('rak_id');
        $data->nama_barang = $request->input('nama_barang');
        $data->satuan = $request->input('satuan');
        $data->harga = $request->input('harga');
        $data->stock = $request->input('stock');
        $data->catatan = $request->input('catatan');
        $data->diskon = $request->input('diskon') ??  null;
        $data->save();

        return response()->json(['msg' => 'Data berhasil diubah'],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($barang)
    {
        $data = Barang::find($barang);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'],404);

        $data->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'],200);
    }
}
