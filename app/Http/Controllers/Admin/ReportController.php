<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function index(Request $request)
{
    $query = Transaction::with('details');

    if ($request->from && $request->to) {
        $query->whereBetween('created_at', [
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59'
        ]);
    } elseif ($request->from) {
        $query->whereDate('created_at', '>=', $request->from);
    } elseif ($request->to) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    $transactions = $query->latest()->get();

    return view('admin.report', [
        'transactions' => $transactions,
        'totalTransaction' => $transactions->count(),
        'totalIncome' => $transactions->sum('total'),
    ]);
}
}