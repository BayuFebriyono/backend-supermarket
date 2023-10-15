<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'diskon' => 'numeric'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        $data = $validator->validated();
        $data['user_id'] = Auth::user()->id;
        $data['tanggal'] = now();
        $transaksi = Transaksi::create($data);
        return response()->json(['msg' => 'Transaksi berhasil dibuat', 'data' => $transaksi], 201);
    }

    public function update(Request $request, $transaksi)
    {
        $data = Transaksi::find($transaksi);
        if (!$data)  return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $validator = Validator::make($request->all(), [
            'total' => 'required|numeric'
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $validated = $validator->validated();
        $data->update($validated);

        return response()->json(['msg' => 'Data berhasil diupdate']);
    }

    public function show($transaksi)
    {
        $data = Transaksi::find($transaksi);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        return response()->json([$data], 200);
    }

    public function destroy($transaksi)
    {
        $data = Transaksi::find($transaksi);
        if (!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $data->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'], 200);
    }
}
