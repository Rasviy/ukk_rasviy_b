<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('details.menu');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $transactions = $query->latest()->get();

        $totalTransaction = $transactions->count();

        // 🔥 GUNAKAN SATU SAJA (BIAR GA BINGUNG)
        $totalIncome = $transactions->sum('total');

        return view('admin.report', compact(
            'transactions',
            'totalTransaction',
            'totalIncome' // ✅ FIX DI SINI
        ));
    }
}