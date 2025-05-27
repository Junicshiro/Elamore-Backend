<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Ambil semua produk
    public function index()
    {
        return response()->json(Product::all());
    }

    // Tambah produk
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'required|string',
            'deskripsi' => 'nullable',
            'kategori' => 'required',
            'stok' => 'required|integer',
        ]);

        $produk = Product::create($request->all());

        return response()->json(['message' => 'Produk berhasil ditambahkan', 'produk' => $produk], 201);
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $produk = Product::findOrFail($id);

        $produk->update($request->all());

        return response()->json(['message' => 'Produk berhasil diperbarui', 'produk' => $produk]);
    }

    // Hapus produk
    public function destroy($id)
    {
        $produk = Product::findOrFail($id);
        $produk->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
