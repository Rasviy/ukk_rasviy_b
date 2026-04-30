<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class QrisController extends Controller
{
    public function show($id)
    {
        
        $trx = Transaction::with('details.menu')->findOrFail($id);

        return view('qris', compact('trx'));
    }
}