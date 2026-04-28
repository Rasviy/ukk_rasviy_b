<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionAdminController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('details.menu')->latest()->get();

        return view('admin.transactions', compact('transactions'));
    }
}