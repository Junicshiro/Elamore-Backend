<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem; // Pastikan import model CartItem
use Illuminate\Support\Facades\DB; // import DB untuk raw

class CartController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = CartItem::updateOrCreate(
            ['user_id' => $validated['user_id'], 'product_id' => $validated['product_id']],
            ['quantity' => \DB::raw('quantity + ' . $validated['quantity'])]
        );

        return response()->json(['message' => 'Keranjang diperbarui', 'cart' => $cart]);
    }

    public function index($user_id)
    {
        $cart = CartItem::with('product')->where('user_id', $user_id)->get();
        return response()->json($cart);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = CartItem::findOrFail($id);
        $cart->update(['quantity' => $validated['quantity']]);

        return response()->json(['message' => 'Jumlah diperbarui', 'cart' => $cart]);
    }

    public function destroy($id)
    {
        CartItem::destroy($id);
        return response()->json(['message' => 'Produk dihapus dari keranjang']);
    }

}
