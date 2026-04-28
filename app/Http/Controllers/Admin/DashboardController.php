<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        // 💰 total uang masuk
        $totalSales = Transaction::sum('total');

        // 🧾 total transaksi
        $totalTransaksi = Transaction::count();

        // 📦 total item terjual
        $totalProduk = TransactionDetail::sum('qty');

        // ❗ produk yang tidak pernah ada di transaksi
        $produkKosong = Menu::whereDoesntHave('transactionDetails')->count();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalTransaksi',
            'totalProduk',
            'produkKosong'
        ));
    }

    public function chartData()
    {
        $data = Transaction::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $data->pluck('date'),
            'data' => $data->pluck('total')
        ]);
    }
}