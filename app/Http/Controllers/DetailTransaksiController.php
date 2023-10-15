<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Validator;

class DetailTransaksiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaksi_id' => 'required|exists:transaksis,id',
            'barang_id' => 'required|exists:barangs,id',
            'unit' => 'required|numeric',
            'diskon' => 'numeric'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $barang = Barang::find($request->input('barang_id'));
        $validated = $validator->validated();

        $validated['harga_unit'] = $barang->harga;

        DetailTransaksi::create($validated);
        $barang->update([
            'stock' => $barang->stock - $request->input('unit')
        ]);

        return response()->json(['msg' => 'Detail order berhasil ditambahkan'], 201);
    }

    public function destoryByTransaksiId($id)
    {
        $transaksi = DetailTransaksi::where('transaksi_id', $id)->get();

        if (!$transaksi->count()) return response()->json(['msg' => 'id transaksi tidak ditemukan'], 404);

        DetailTransaksi::where('transaksi_id', $id)->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'], 200);
    }

    public function destroy($id)
    {
        $transaksi = DetailTransaksi::find($id);
        if(!$transaksi) return response()->json(['msg' => 'id tidak ditemukan'], 404);

        $transaksi->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'], 200);
    }
}
