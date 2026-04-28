<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class StrukController extends Controller
{
    public function show($id)
    {
        $trx = Transaction::with('details.menu')->findOrFail($id);

        return view('struk', compact('trx'));
    }

    public function pdf($id)
    {
        $trx = Transaction::with('details.menu')->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('struk', compact('trx'));

        return $pdf->download('struk-'.$id.'.pdf');
    }
}