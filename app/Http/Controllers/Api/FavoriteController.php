<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite; // Pastikan import model Favorite

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $favorite = Favorite::firstOrCreate($validated);

        return response()->json(['message' => 'Favorit ditambahkan', 'favorite' => $favorite]);
    }

    public function getByUser($id)
    {
        return Favorite::with('product')->where('user_id', $id)->get();
    }

    public function destroy($id)
    {
        $favorite = Favorite::find($id);

        if (!$favorite) {
            return response()->json(['message' => 'Data favorit tidak ditemukan'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Data favorit berhasil dihapus']);
    }

}
