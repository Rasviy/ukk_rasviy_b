<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 🔥 IMPORT OOP
use App\Services\CashPayment;
use App\Services\QRISPayment;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'payment_method' => 'required'
        ]);

        // buat transaksi
       $transaction = Transaction::create([
    'user_id' => auth()->id(),
    'tanggal' => now(),
    'total' => 0,
    'tax' => 0,
    'payment_method' => $request->payment_method,
    'uang_bayar' => $request->uang_bayar ?? 0,
    'kembalian' => $request->kembalian ?? 0,
]);

        $total = 0;

        foreach ($request->items as $item) {

            $menu = Menu::findOrFail($item['menu_id']);

            $subtotal = $menu->harga * $item['qty'];

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'menu_id' => $menu->id,
                'qty' => $item['qty'],
                'harga' => $menu->harga,
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;
        }

        // 🔥 FIX UTAMA: cast ke integer biar ga 0
        $tax = (int) ($total * 0.050); // 2.0% tax, bisa diubah sesuai kebutuhan

        // update total + tax
        $transaction->update([
            'tax' => $tax,
            'total' => $total + $tax,
            'uang_bayar' => $request->uang_bayar ?? 0,
            'kembalian' => $request->kembalian ?? 0,
        ]);

        // OOP payment
        $paymentType = $request->payment_method;

        if ($paymentType == 'cash') {
            $payment = new CashPayment();
        } else {
            $payment = new QRISPayment();
        }

        // kirim total yang sudah include tax
        $hasilBayar = $payment->pay($total + $tax);

        // log activity
        if (auth()->check()) {
            LogActivity::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Membuat transaksi',
                'waktu' => now()
            ]);
        }

        return response()->json([
            'message' => 'success',
            'transaction_id' => $transaction->id
        ]);
    }
}
