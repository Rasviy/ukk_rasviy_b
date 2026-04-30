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
        <h3 style="margin:0;">☕ CafeInAja</h3>

        <!-- FIX TANGGAL -->
        <p style="margin:4px 0;">
            Tanggal:
            @php
                $tanggal = $trx->tanggal;

                if ($tanggal instanceof \Carbon\Carbon) {
                    echo $tanggal->format('d/m/Y H:i');
                } else {
                    echo date('d/m/Y H:i', strtotime($tanggal));
                }
            @endphp
        </p>

        <p style="margin:4px 0;">No. Transaksi: #{{ $trx->id }}</p>
    </div>

    <hr>

    <!-- ✅ TAMBAHAN CUSTOMER -->
    <div class="flex">
        <span>Pelanggan</span>
        <span>{{ $trx->customer_name ?? 'Guest' }}</span>
    </div>

    @if (isset($trx->meja))
        <div class="flex">
            <span>Meja</span>
            <span>{{ $trx->meja }}</span>
        </div>
    @endif

    <hr>

    @php
        $subtotal = ($trx->total ?? 0) - ($trx->tax ?? 0);
    @endphp

    <!-- LIST ITEM -->
    @forelse($trx->details as $d)
        <div class="flex">
            <span>
                {{ $d->menu->nama_menu ?? 'Menu' }} x{{ $d->qty ?? 1 }}
            </span>
            <span>
                Rp {{ number_format($d->subtotal ?? 0, 0, ',', '.') }}
            </span>
        </div>
    @empty
        <div class="flex">
            <span>Tidak ada item</span>
            <span>Rp 0</span>
        </div>
    @endforelse

    <hr>

    <div class="flex">
        <span>Subtotal</span>
        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
    </div>

    <div class="flex">
        <span>Tax (5%)</span>
        <span>Rp {{ number_format($trx->tax ?? 0, 0, ',', '.') }}</span>
    </div>

    <hr>

    <div class="flex bold">
        <span>Total</span>
        <span>Rp {{ number_format($trx->total ?? 0, 0, ',', '.') }}</span>
    </div>

    <hr>

    <div class="flex">
        <span>Metode</span>
        <span>{{ strtoupper($trx->payment_method ?? 'CASH') }}</span>
    </div>

    @if (($trx->payment_method ?? 'cash') == 'cash')
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
