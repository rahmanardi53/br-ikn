<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            // 'kategori' => 'nullable|string|max:255',
            'harga' => 'required|integer',
            'komisi' => 'required|integer',
        ]);

        Barang::create($request->all());

        return back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            // 'kategori' => 'nullable|string|max:255',
            'harga' => 'required|integer',
            'komisi' => 'required|integer',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return back()->with('success', 'Barang berhasil dihapus.');
    }
}
