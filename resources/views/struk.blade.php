<!DOCTYPE html>
<html>
<head>
    <title>Struk</title>
    <style>
        body {
            font-family: monospace;
            width: 280px;
            margin: auto;
            padding: 10px;
            font-size: 13px;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .flex {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
        }
        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body onload="window.print()">

<div class="center">
    <h3 style="margin:0;">☕ CUMA Cafe</h3>
    <p style="margin:4px 0;">Tanggal: {{ $trx->tanggal }}</p>
    <p style="margin:4px 0;">No. Transaksi: #{{ $trx->id }}</p>
</div>

<hr>

@php
    $subtotal = $trx->total - $trx->tax;
@endphp

@foreach($trx->details as $d)
<div class="flex">
    <span>{{ $d->menu->nama_menu }} x{{ $d->qty }}</span>
    <span>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
</div>
@endforeach

<hr>

<div class="flex">
    <span>Subtotal</span>
    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
</div>

<div class="flex">
    <span>Tax (5%)</span>
    <span>Rp {{ number_format($trx->tax, 0, ',', '.') }}</span>
</div>

<hr>

<div class="flex bold">
    <span>Total</span>
    <span>Rp {{ number_format($trx->total, 0, ',', '.') }}</span>
</div>

<hr>

<div class="flex">
    <span>Metode</span>
    <span>{{ strtoupper($trx->payment_method ?? 'CASH') }}</span>
</div>

@if(($trx->payment_method ?? 'cash') == 'cash')
    <div class="flex">
        <span>Uang Bayar</span>
        <span>Rp {{ number_format($trx->uang_bayar ?? 0, 0, ',', '.') }}</span>
    </div>

    <div class="flex bold">
        <span>Kembalian</span>
        <span>Rp {{ number_format($trx->kembalian ?? 0, 0, ',', '.') }}</span>
    </div>
@else
    <div class="flex bold">
        <span>Status</span>
        <span>LUNAS (QRIS)</span>
    </div>
@endif

<hr>

<p class="center">Terima kasih 🙏</p>
<p class="center">Selamat menikmati ☕</p>

</body>
</html>