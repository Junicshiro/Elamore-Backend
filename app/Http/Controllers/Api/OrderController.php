<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nomor_hp' => 'required|string',
            'items' => 'required|array',
            'total_harga' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $request->user_id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'nomor_hp' => $request->nomor_hp,
                'total_harga' => $request->total_harga,
                'status' => 'pending',
            ]);

            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['quantity'] * $item['product']['harga'],
                ]);
            }

            CartItem::where('user_id', $request->user_id)->delete();
            DB::commit();

            return response()->json(['message' => 'Pesanan berhasil dibuat', 'order_id' => $order->id], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal memproses pesanan', 'error' => $e->getMessage()], 500);
        }
    }

    public function getByUser($id)
    {
        return Order::with('items.product')->where('user_id', $id)->latest()->get();
    }

    public function all()
    {
        return Order::with('items.product')->latest()->get();
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,shipped,delivered,canceled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status diperbarui']);
    }

}
