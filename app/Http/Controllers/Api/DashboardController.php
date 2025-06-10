<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function summary()
    {
        $totalProduk = Product::count();
        $totalPengguna = User::count();
        $totalPesanan = Order::count();
        $totalPendapatan = Order::where('status', 'delivered')->sum('total_harga');

        // Statistik bulanan (6 bulan terakhir)
        $bulan = [];
        $pendapatanBulanan = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulanLabel = now()->subMonths($i)->format('M');
            $bulan[] = $bulanLabel;

            $pendapatan = Order::where('status', 'delivered')
                ->whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->sum('total_harga');

            $pendapatanBulanan[] = $pendapatan;
        }

        // Status pesanan
        $status = [
            'pesanan_pending' => Order::where('status', 'pending')->count(),
            'pesanan_confirmed' => Order::where('status', 'confirmed')->count(),
            'pesanan_shipped' => Order::where('status', 'shipped')->count(),
            'pesanan_delivered' => Order::where('status', 'delivered')->count(),
            'pesanan_canceled' => Order::where('status', 'canceled')->count(),
        ];

        return response()->json([
            'produk' => $totalProduk,
            'pengguna' => $totalPengguna,
            'pesanan' => $totalPesanan,
            'pendapatan' => $totalPendapatan,
            'bulan' => $bulan,
            'pendapatan_bulanan' => $pendapatanBulanan,
            'status' => $status,
        ]);
    }
}
