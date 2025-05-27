<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function summary()
    {
        $totalProduk = Product::count();
        $totalPesanan = Order::count();
        $totalPengguna = User::count();

        $pendapatanBulanIni = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'canceled')
            ->sum('total_harga');

        return response()->json([
            'produk' => $totalProduk,
            'pesanan' => $totalPesanan,
            'pengguna' => $totalPengguna,
            'pendapatan' => $pendapatanBulanIni
        ]);
    }
}

