<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | CafeInAja</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .stat-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }

        /* Chart container */
        .chart-container {
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }

        /* Custom animation for cards */
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
            animation: fadeInUp 0.5s ease forwards;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        /* Active page indicator */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #f3f4f6 100%);
        }
    </style>
</head>

<body class="font-sans antialiased">

    @include('admin.layouts.navbar')

    <div class="ml-64 min-h-screen">
        <div class="p-6 max-w-7xl mx-auto">

            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                            <i class="fas fa-chart-line text-green-700"></i>
                            Dashboard Overview
                        </h1>
                        <p class="text-gray-500 mt-1">Welcome back, Admin! Here's your sales summary</p>
                    </div>
                    <div
                        class="flex items-center gap-2 text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                        <i class="fas fa-calendar-alt text-green-600"></i>
                        <span id="currentDate"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="stat-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Total Sales</p>
                            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalSales ?? 0) }}</p>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up"></i> +12.5% from last month
                            </p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="fas fa-dollar-sign text-green-700 text-xl"></i>
                        </div>
                    </div>
                </div>

                
                <div class="stat-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Transaksi</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalTransaksi ?? 0 }}</p>
                            <p class="text-xs text-blue-600 mt-2">
                                <i class="fas fa-receipt"></i> Total Orders
                            </p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <i class="fas fa-shopping-cart text-blue-700 text-xl"></i>
                        </div>
                    </div>
                </div>

                
                <div class="stat-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Produk Terjual</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalProduk ?? 0 }}</p>
                            <p class="text-xs text-purple-600 mt-2">
                                <i class="fas fa-box"></i> Items Sold
                            </p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <i class="fas fa-cube text-purple-700 text-xl"></i>
                        </div>
                    </div>
                </div>

                
                <div class="stat-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-600">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Produk Tidak Laku</p>
                            <p class="text-2xl font-bold text-red-600">{{ $produkKosong ?? 0 }}</p>
                            <p class="text-xs text-red-600 mt-2">
                                <i class="fas fa-exclamation-triangle"></i> Slow Moving Items
                            </p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <i class="fas fa-box-open text-red-700 text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>

            <div class="chart-container bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800 text-xl flex items-center gap-2">
                        <i class="fas fa-chart-line text-green-700"></i>
                        Grafik Penjualan
                    </h3>
                    <div class="flex gap-2">
                        <button onclick="loadChart('harian')"
                            class="text-xs bg-gray-100 px-3 py-1 rounded-full">Harian</button>
                        <button onclick="loadChart('mingguan')"
                            class="text-xs bg-green-600 text-white px-3 py-1 rounded-full">Mingguan</button>
                        <button onclick="loadChart('bulanan')"
                            class="text-xs bg-gray-100 px-3 py-1 rounded-full">Bulanan</button>
                    </div>
                </div>
                <canvas id="salesChart" class="max-h-96"></canvas>
            </div>


        </div>
    </div>

    <script>
        // Display current date
        function updateDate() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const dateElem = document.getElementById('currentDate');
            if (dateElem) {
                dateElem.innerHTML = now.toLocaleDateString('id-ID', options);
            }
        }
        updateDate();

        fetch('/admin/chart-data')
            .then(r => r.json())
            .then(data => {
                new Chart(document.getElementById('salesChart'), {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Penjualan',
                            data: data.data,
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
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    },
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
                                grid: {
                                    color: '#e2e8f0'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
                // Fallback data
                new Chart(document.getElementById('salesChart'), {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                            'Des'
                        ],
                        datasets: [{
                            label: 'Penjualan',
                            data: [5000000, 6500000, 7200000, 8100000, 9500000, 10200000, 11800000,
                                12500000, 13200000, 14800000, 15900000, 17200000
                            ],
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
                        scales: {
                            y: {
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            });
    </script>

</body>

</html>
