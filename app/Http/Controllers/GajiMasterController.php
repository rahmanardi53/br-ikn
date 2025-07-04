<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiMaster;
use App\Models\User;

class GajiMasterController extends Controller
{
    public function index()
    {
        $gajis = GajiMaster::with('user')->get();
        $users = User::all();

        return view('master_gaji.index', compact('gajis', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        GajiMaster::create($request->all());

        return back()->with('success', 'Data gaji berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        $gaji = GajiMaster::findOrFail($id);
        $gaji->update($request->all());

        return back()->with('success', 'Data gaji berhasil diupdate.');
    }

    public function destroy($id)
    {
        GajiMaster::destroy($id);
        return back()->with('success', 'Data gaji berhasil dihapus.');
    }
}
