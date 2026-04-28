<!DOCTYPE html>
<html>
<head>
    <title>QRIS Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 text-center">

    <!-- HEADER -->
    <h1 class="text-2xl font-bold text-gray-800 mb-1">
        💳 QRIS PAYMENT
    </h1>

    <p class="text-xs text-gray-400 mb-4">
        Transaction ID: #{{ $trx->id }}
    </p>

    <!-- AMOUNT -->
    <div class="bg-green-50 rounded-lg p-4 mb-5">
        <p class="text-sm text-gray-500">Total Pembayaran</p>
        <h2 class="text-3xl font-bold text-green-600">
            Rp {{ number_format($trx->total) }}
        </h2>
    </div>

    <!-- QR CODE -->
    <div class="flex justify-center mb-5">
        <div class="bg-white p-3 rounded-xl shadow border">
            <img
                class="w-48 h-48"
                src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=TRX-{{ $trx->id }}-{{ $trx->total }}"
                alt="QRIS"
            >
        </div>
    </div>

    <!-- INFO -->
    <p class="text-sm text-gray-500 mb-6">
        Scan QR Code menggunakan aplikasi pembayaran (simulasi QRIS)
    </p>

    <!-- BUTTON -->
    <a href="/struk/{{ $trx->id }}"
       class="block bg-green-500 hover:bg-green-600 transition text-white font-semibold py-3 rounded-xl">
        ✔ Konfirmasi & Lihat Struk
    </a>

    <!-- FOOTER -->
    <p class="text-xs text-gray-400 mt-4">
        Sistem akan otomatis mencatat pembayaran
    </p>

</div>

</body>
</html>