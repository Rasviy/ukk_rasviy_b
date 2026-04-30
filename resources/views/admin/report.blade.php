<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Penjualan - Java Point Cafe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js untuk grafik (opsional, UI only) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Card hover effect */
        .stat-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }

        /* Table styling */
        .report-table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .report-table th {
            background: #f8fafc;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        .report-table tbody tr {
            transition: all 0.2s ease;
        }
        .report-table tbody tr:hover {
            background: #fefce8 !important;
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .stat-card {
            animation: fadeInUp 0.4s ease forwards;
        }
        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }

        /* Filter form styling */
        .filter-input {
            transition: all 0.2s ease;
        }
        .filter-input:focus {
            outline: none;
            ring: 2px solid #2c5a3b;
            border-color: #2c5a3b;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-sans antialiased">

<div class="p-6 max-w-7xl mx-auto">

    <!-- SIDEBAR NAVBAR (di samping kiri) -->
    @include('admin.layouts.navbar')

    <!-- MAIN CONTENT (dengan margin left sesuai sidebar) -->
    <div class="ml-64">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <i class="fas fa-chart-bar text-green-700"></i>
                        Report Penjualan
                    </h1>
                    <p class="text-gray-500 mt-2">Comprehensive sales report and transaction analysis</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 bg-white px-5 py-2.5 rounded-full shadow-sm">
                    <i class="fas fa-calendar-alt text-green-600"></i>
                    <span id="currentDate" class="font-medium"></span>
                </div>
            </div>
        </div>

        <!-- FILTER SECTION (styling tanpa mengubah logic) -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center gap-2 mb-5">
                <i class="fas fa-filter text-green-700 text-xl"></i>
                <h2 class="text-xl font-bold text-gray-800">Filter Laporan</h2>
            </div>
            
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="far fa-calendar-alt mr-1 text-green-600"></i> Dari Tanggal
                    </label>
                    <input type="date"
                           name="from"
                           value="{{ request('from') }}"
                           class="filter-input w-full border border-gray-300 rounded-xl p-2.5 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition">
                </div>
                
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="far fa-calendar-alt mr-1 text-green-600"></i> Sampai Tanggal
                    </label>
                    <input type="date"
                           name="to"
                           value="{{ request('to') }}"
                           class="filter-input w-full border border-gray-300 rounded-xl p-2.5 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition">
                </div>
                
                <div class="flex gap-3">
                    <button class="bg-gradient-to-r from-[#1e3a2f] to-[#2c5a3b] hover:from-[#153728] hover:to-[#1f4735] text-white px-6 py-2.5 rounded-xl font-medium transition-all duration-200 flex items-center gap-2 shadow-sm">
                        <i class="fas fa-search"></i>
                        <span>Filter</span>
                    </button>
                    
                    @if(request('from') || request('to'))
                    <a href="/admin/report"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-xl font-medium transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-undo-alt"></i>
                        <span>Reset</span>
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- SUMMARY CARDS dengan desain premium -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <!-- Total Transaksi Card -->
            <div class="stat-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-600">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Transaksi</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalTransaction ?? 0 }}</p>
                        <p class="text-xs text-blue-600 mt-2">
                            <i class="fas fa-receipt"></i> Semua transaksi
                        </p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-shopping-cart text-blue-700 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Income Card -->
            <div class="stat-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-600">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Income</p>
                        <p class="text-3xl font-bold text-green-600">
                            Rp {{ number_format($totalIncome ?? 0) }}
                        </p>
                        <p class="text-xs text-green-600 mt-2">
                            <i class="fas fa-chart-line"></i> Pendapatan kotor
                        </p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-dollar-sign text-green-700 text-2xl"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- GRAFIK PENJUALAN (UI only, tidak mengubah logic asli) -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center gap-2 mb-5">
                <i class="fas fa-chart-line text-green-700 text-xl"></i>
                <h2 class="text-xl font-bold text-gray-800">Grafik Penjualan</h2>
            </div>
            <canvas id="salesChart" class="max-h-80"></canvas>
        </div>

        <!-- DETAIL TRANSAKSI TABLE -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-table-list text-green-700 text-xl"></i>
                        <h2 class="text-xl font-bold text-gray-800">Detail Transaksi</h2>
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle"></i>
                        <span>Total: {{ $transactions->count() ?? 0 }} transaksi</span>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="report-table w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-4 text-left font-semibold text-gray-700">
                                <i class="fas fa-hashtag mr-1 text-green-600"></i> ID
                            </th>
                            <th class="p-4 text-left font-semibold text-gray-700">
                                <i class="far fa-calendar-alt mr-1 text-green-600"></i> Tanggal
                            </th>
                            <th class="p-4 text-left font-semibold text-gray-700">
                                <i class="fas fa-money-bill-wave mr-1 text-green-600"></i> Total
                            </th>
                            <th class="p-4 text-left font-semibold text-gray-700">
                                <i class="fas fa-credit-card mr-1 text-green-600"></i> Metode
                            </th>
                            <th class="p-4 text-left font-semibold text-gray-700">
                                <i class="fas fa-cube mr-1 text-green-600"></i> Items
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transactions as $t)
                        <tr class="border-b hover:bg-amber-50/30 transition">
                            <td class="p-4 font-mono font-semibold text-gray-700">
                                #{{ $t->id }}
                            </td>
                            <td class="p-4 text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-clock text-gray-400 text-xs"></i>
                                    {{ $t->created_at->format('d-m-Y H:i') }}
                                </div>
                            </td>
                            <td class="p-4 text-green-600 font-bold">
                                Rp {{ number_format($t->total) }}
                            </td>
                            <td class="p-4">
                                <span class="badge-payment px-3 py-1 rounded-full text-xs font-medium">
                                    <i class="fas {{ isset($t->payment_method) && $t->payment_method == 'qris' ? 'fa-qrcode' : 'fa-money-bill' }} mr-1"></i>
                                    {{ isset($t->payment_method) ? strtoupper($t->payment_method) : 'CASH' }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-box"></i>
                                    {{ $t->details->count() ?? 0 }} item
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-400">
                                <i class="fas fa-inbox text-5xl mb-3 block"></i>
                                <p>Tidak ada transaksi dalam periode ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="bg-gray-100 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="2" class="p-4 text-right font-bold text-gray-700">
                                Total Keseluruhan:
                            </td>
                            <td class="p-4 font-bold text-green-700 text-lg">
                                Rp {{ number_format($transactions->sum('total') ?? 0) }}
                            </td>
                            <td colspan="2" class="p-4"></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>

        <!-- EXPORT SECTION (informasi tambahan) -->
        <div class="mt-6 text-center text-xs text-gray-400">
            <i class="fas fa-print"></i>
            <span>Laporan dapat diexport ke PDF menggunakan tombol Export PDF di atas</span>
        </div>

    </div>

</div>

<script>
    // Display current date
    function updateDate() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateElem = document.getElementById('currentDate');
        if (dateElem) {
            dateElem.innerHTML = now.toLocaleDateString('id-ID', options);
        }
    }
    updateDate();

    // Grafik Penjualan (UI only, berdasarkan data dari tabel)
    function initChart() {
        const ctx = document.getElementById('salesChart');
        if (!ctx) return;
        
        // Ambil data dari tabel yang sudah ada
        const rows = document.querySelectorAll('.report-table tbody tr');
        const labels = [];
        const data = [];
        
        rows.forEach(row => {
            const dateCell = row.cells[1];
            const totalCell = row.cells[2];
            if (dateCell && totalCell) {
                const dateText = dateCell.innerText.trim().split(' ')[0]; // ambil tanggal saja
                const totalText = totalCell.innerText.replace('Rp', '').replace(/\./g, '').trim();
                const totalValue = parseInt(totalText) || 0;
                
                // Kelompokkan berdasarkan tanggal
                const existingIndex = labels.indexOf(dateText);
                if (existingIndex === -1) {
                    labels.push(dateText);
                    data.push(totalValue);
                } else {
                    data[existingIndex] += totalValue;
                }
            }
        });
        
        // Jika tidak ada data, tampilkan grafik kosong
        if (labels.length === 0) {
            labels.push('Tidak ada data');
            data.push(0);
        }
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: data,
                    borderColor: '#2c5a3b',
                    backgroundColor: 'rgba(44, 90, 59, 0.05)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#1e3a2f',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { size: 12, weight: 'bold' },
                            usePointStyle: true,
                            boxWidth: 10
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e3a2f',
                        titleColor: '#fff',
                        bodyColor: '#e2e8f0',
                        callbacks: {
                            label: function(context) {
                                return 'Penjualan: Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: { color: '#e2e8f0' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
    
    // Jalankan grafik setelah halaman load
    document.addEventListener('DOMContentLoaded', function() {
        initChart();
    });
</script>

<style>
    .badge-payment {
        background: #e0f2fe;
        color: #0369a1;
    }
    .badge-payment i {
        font-size: 0.7rem;
    }
    
    @media print {
        .ml-64 > div:first-child, .filter-input, button, a, .badge-payment, .chart-container {
            display: none !important;
        }
        .stat-card, .bg-white, .report-table {
            box-shadow: none;
            border: 1px solid #ddd;
        }
        body {
            background: white;
        }
    }
</style>

</body>
</html>