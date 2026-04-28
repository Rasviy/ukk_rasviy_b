<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Java Point Cafe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        .transaction-card {
            transition: all 0.3s ease;
        }
        .transaction-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }

        /* Badge styling */
        .badge {
            transition: all 0.2s ease;
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
        .transaction-card {
            animation: fadeInUp 0.4s ease forwards;
        }
        .transaction-card:nth-child(n) {
            animation-delay: calc(0.05s * var(--item-index, 0));
        }

        /* Table styling */
        .transaction-table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .transaction-table th {
            background: #f8fafc;
            font-weight: 600;
        }
        .transaction-table tbody tr:hover {
            background: #fefce8;
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
                        <i class="fas fa-receipt text-green-700"></i>
                        Semua Transaksi
                    </h1>
                    <p class="text-gray-500 mt-2">Manage and view all cafe transactions history</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 bg-white px-5 py-2.5 rounded-full shadow-sm">
                    <i class="fas fa-chart-line text-green-600"></i>
                    <span class="font-medium">Total: <span id="totalTransactions">{{ $transactions->count() ?? 0 }}</span> transaksi</span>
                </div>
            </div>
        </div>

        <!-- FILTER & SEARCH SECTION (opsional, tanpa mengubah logic asli) -->
        <div class="bg-white rounded-2xl shadow-md p-4 mb-6">
            <div class="flex flex-wrap gap-3 items-center justify-between">
                <div class="flex gap-2">
                    <button class="filter-btn active px-4 py-2 rounded-xl text-sm font-medium transition" data-filter="all">
                        <i class="fas fa-list mr-1"></i> Semua
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-xl text-sm font-medium transition" data-filter="today">
                        <i class="fas fa-calendar-day mr-1"></i> Hari Ini
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-xl text-sm font-medium transition" data-filter="week">
                        <i class="fas fa-calendar-week mr-1"></i> Minggu Ini
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-xl text-sm font-medium transition" data-filter="month">
                        <i class="fas fa-calendar-alt mr-1"></i> Bulan Ini
                    </button>
                </div>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchTransaction" placeholder="Cari transaksi..." class="pl-9 pr-4 py-2 border border-gray-300 rounded-xl text-sm w-64 focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500">
                </div>
            </div>
        </div>

        <!-- LIST TRANSAKSI -->
        <div class="space-y-5" id="transactionsList">
            
            @foreach($transactions as $index => $trx)
            <div class="transaction-card bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100" style="--item-index: {{ $index }}" data-transaction-id="{{ $trx->id }}" data-transaction-date="{{ $trx->created_at->format('Y-m-d') }}">
                
                <!-- HEADER TRX dengan gradient -->
                <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center flex-wrap gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-receipt text-green-700 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">
                                    TRX #{{ $trx->id }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $trx->created_at->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-green-600 font-bold text-2xl">
                                Rp {{ number_format($trx->total) }}
                            </div>
                            <div class="flex items-center gap-2 mt-1 justify-end">
                                <span class="badge bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                                    <i class="fas fa-check-circle"></i> Completed
                                </span>
                                <span class="text-xs text-gray-400">
                                    <i class="fas fa-box"></i> {{ $trx->details->count() }} items
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DETAIL ITEM TABLE -->
                <div class="px-6 py-4">
                    <div class="overflow-x-auto">
                        <table class="transaction-table w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-600 border-b border-gray-200">
                                    <th class="pb-2 font-semibold">
                                        <i class="fas fa-utensil-spoon mr-1 text-green-600"></i> Menu
                                    </th>
                                    <th class="pb-2 font-semibold text-center w-20">
                                        <i class="fas fa-shopping-cart mr-1 text-green-600"></i> Qty
                                    </th>
                                    <th class="pb-2 font-semibold text-right w-36">
                                        <i class="fas fa-money-bill-wave mr-1 text-green-600"></i> Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trx->details as $detail)
                                <tr class="border-b border-gray-100 hover:bg-amber-50/30 transition">
                                    <td class="py-2 text-gray-700">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-circle text-green-600 text-xs"></i>
                                            {{ $detail->menu->nama_menu }}
                                        </div>
                                    </td>
                                    <td class="py-2 text-center font-medium text-gray-700">
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-xs font-bold">
                                            x{{ $detail->qty }}
                                        </span>
                                    </td>
                                    <td class="py-2 text-right font-semibold text-gray-800">
                                        Rp {{ number_format($detail->qty * $detail->menu->harga) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-t-2 border-gray-200">
                                <tr>
                                    <td colspan="2" class="pt-3 text-right font-bold text-gray-700">
                                        Total:
                                    </td>
                                    <td class="pt-3 text-right font-bold text-green-700 text-lg">
                                        Rp {{ number_format($trx->total) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <!-- Additional info (payment method) jika ada -->
                    @if(isset($trx->payment_method))
                    <div class="mt-3 pt-2 border-t border-gray-100 flex justify-between items-center">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <i class="fas fa-credit-card"></i>
                            <span>Metode Pembayaran: </span>
                            <span class="font-medium text-gray-700 uppercase">{{ $trx->payment_method }}</span>
                        </div>
                        <button onclick="printTransaction({{ $trx->id }})" class="text-xs text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                            <i class="fas fa-print"></i> Cetak Struk
                        </button>
                    </div>
                    @endif
                </div>

            </div>
            @endforeach

        </div>

        <!-- Jika tidak ada transaksi -->
        @if($transactions->isEmpty())
        <div class="bg-white rounded-2xl shadow-md p-12 text-center">
            <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-400 text-lg">Belum ada transaksi. Silakan lakukan transaksi terlebih dahulu.</p>
            <a href="/" class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded-xl hover:bg-green-700 transition">
                <i class="fas fa-shopping-cart mr-2"></i> Mulai Transaksi
            </a>
        </div>
        @endif

    </div>

</div>

<script>
    // Filter transactions (tanpa mengubah logic asli, hanya UI filtering)
    function filterTransactions(filter) {
        const cards = document.querySelectorAll('.transaction-card');
        const today = new Date().toISOString().split('T')[0];
        const weekAgo = new Date();
        weekAgo.setDate(weekAgo.getDate() - 7);
        const monthAgo = new Date();
        monthAgo.setMonth(monthAgo.getMonth() - 1);
        
        cards.forEach(card => {
            const cardDate = card.getAttribute('data-transaction-date');
            let show = true;
            
            if (filter === 'today') {
                show = cardDate === today;
            } else if (filter === 'week') {
                show = new Date(cardDate) >= weekAgo;
            } else if (filter === 'month') {
                show = new Date(cardDate) >= monthAgo;
            }
            
            card.style.display = show ? 'block' : 'none';
        });
        
        updateVisibleCount();
    }
    
    // Search transactions
    function searchTransactions(keyword) {
        const cards = document.querySelectorAll('.transaction-card');
        const searchLower = keyword.toLowerCase();
        
        cards.forEach(card => {
            const trxId = card.getAttribute('data-transaction-id');
            const trxText = card.innerText.toLowerCase();
            const show = trxText.includes(searchLower) || trxId.includes(searchLower);
            card.style.display = show ? 'block' : 'none';
        });
        
        updateVisibleCount();
    }
    
    // Update visible transaction count
    function updateVisibleCount() {
        const visibleCards = document.querySelectorAll('.transaction-card[style*="display: block"], .transaction-card:not([style*="display: none"])');
        const totalSpan = document.getElementById('totalTransactions');
        if (totalSpan) {
            const visibleCount = Array.from(visibleCards).filter(card => card.style.display !== 'none').length;
            const originalCount = {{ $transactions->count() ?? 0 }};
            if (visibleCount !== originalCount) {
                totalSpan.innerHTML = visibleCount + ' dari ' + originalCount;
            } else {
                totalSpan.innerHTML = originalCount;
            }
        }
    }
    
    // Print transaction receipt
    function printTransaction(trxId) {
        window.open('/struk/' + trxId, '_blank');
    }
    
    // Event listeners untuk filter dan search
    document.addEventListener('DOMContentLoaded', function() {
        // Filter buttons
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const filter = this.getAttribute('data-filter');
                if (filter === 'all') {
                    document.querySelectorAll('.transaction-card').forEach(card => card.style.display = 'block');
                    updateVisibleCount();
                } else {
                    filterTransactions(filter);
                }
            });
        });
        
        // Search input
        const searchInput = document.getElementById('searchTransaction');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                searchTransactions(this.value);
            });
        }
        
        // Reset filter when search is cleared
        const resetFilters = () => {
            if (searchInput && searchInput.value === '') {
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    if (btn.getAttribute('data-filter') === 'all') {
                        btn.click();
                    }
                });
            }
        };
        
        if (searchInput) {
            searchInput.addEventListener('blur', resetFilters);
        }
    });
</script>

<style>
    .filter-btn {
        background: #f3f4f6;
        color: #4b5563;
        border: none;
        cursor: pointer;
    }
    .filter-btn.active {
        background: #1e3a2f;
        color: white;
        box-shadow: 0 2px 8px rgba(30, 58, 47, 0.3);
    }
    .filter-btn:hover:not(.active) {
        background: #e5e7eb;
    }
    
    /* Print style */
    @media print {
        .filter-btn, #searchTransaction, .badge, .transaction-card button, .ml-64 > div:first-child, .bg-white.rounded-2xl.shadow-md.p-4 {
            display: none !important;
        }
        .transaction-card {
            break-inside: avoid;
            page-break-inside: avoid;
        }
    }
</style>

</body>
</html>