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
    
        $totalSales = Transaction::sum('total');

        
        $totalTransaksi = Transaction::count();

        
        $totalProduk = TransactionDetail::sum('qty');

       
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