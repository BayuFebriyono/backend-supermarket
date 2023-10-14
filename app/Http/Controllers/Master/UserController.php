<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'karyawan_id' => 'exists:karyawans,id|required',
            'posisi_id' => 'exists:posisis,id|required',
            'username' => 'unique:users,username|required',
            'email' => 'required|email',
            'password' => 'required|min:6'

        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $validator->validated();
        $data['password'] = bcrypt($request->input('password'));
        $user = User::create($data);

        return response()->json(['msg' => 'User berhasil dibuat', 'data' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        $data = User::find($user);
        if (!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        $data = User::find($user);
        if (!$data) return response()->json(['msg' => 'Data tidak ditemukan'], 404);

        $validator = Validator::make($request->all(), [
            'karyawan_id' => 'exists:karyawans,id|required',
            'posisi_id' => 'exists:posisis,id|required',
            'username' => ['required', Rule::unique('users', 'username')->where(function ($q) use ($data) {
                return $q->where('username', '!=', $data->username);
            })],
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $validated = $validator->validated();
        $validated['password'] = bcrypt($request->input('password'));
        $data->update($validated);
        return response()->json(['msg' => 'Data berhasil diperbatui'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user)
    {
        $data = User::find($user);
        if(!$data) return response()->json(['msg' => 'Data tidak ditemukan'],404);

        $data->delete();
        return response()->json(['msg' => 'Data berhasil dihapus'],200);
    }
}
