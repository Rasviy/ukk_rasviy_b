<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\CashPayment;
use App\Services\QRISPayment;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'items' => 'required|array',
        'payment_method' => 'required|in:cash,qris',
        'customer_name' => 'nullable|string|max:100'
    ]);

    DB::beginTransaction();

    try {

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total' => 0,
            'tax' => 0,
            'payment_method' => $request->payment_method,
            'uang_bayar' => $request->uang_bayar ?? 0,
            'kembalian' => $request->kembalian ?? 0,
            'customer_name' => $request->customer_name ?? 'Guest',
        ]);

        $total = 0;

        foreach ($request->items as $item) {

            $menu = Menu::lockForUpdate()->findOrFail($item['menu_id']);

            if ($menu->stok < $item['qty']) {
                throw new \Exception("Stok {$menu->nama_menu} tidak cukup!");
            }

            $subtotal = $menu->harga * $item['qty'];

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'menu_id' => $menu->id,
                'qty' => $item['qty'],
                'harga' => $menu->harga,
                'subtotal' => $subtotal
            ]);

            $menu->stok -= $item['qty'];
            $menu->save();

            $total += $subtotal;
        }

        
        $tax = (int) ($total * 0.05);

        $grandTotal = $total + $tax;

        $transaction->update([
            'tax' => $tax,
            'total' => $grandTotal,
            'uang_bayar' => $request->uang_bayar ?? 0,
            'kembalian' => $request->kembalian ?? 0,
        ]);

        
        $payment = $request->payment_method == 'cash'
            ? new CashPayment()
            : new QRISPayment();

        $payment->pay($grandTotal);

        
        if (auth()->check()) {
            LogActivity::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Membuat transaksi #' . $transaction->id,
                'waktu' => now()
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'success',
            'transaction_id' => $transaction->id
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'message' => $e->getMessage()
        ], 500);
    }
}
}