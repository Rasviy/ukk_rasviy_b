<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management - Java Point Cafe</title>
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
        .menu-card {
            transition: all 0.3s ease;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }

        /* Form input focus effect */
        .form-input:focus {
            outline: none;
            ring: 2px solid #2c5a3b;
            border-color: #2c5a3b;
        }

        /* Animation for cards */
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
        .menu-card {
            animation: fadeInUp 0.4s ease forwards;
        }
        .menu-card:nth-child(n) {
            animation-delay: calc(0.05s * var(--item-index, 0));
        }

        /* File input styling */
        .file-input {
            position: relative;
        }
        .file-input::-webkit-file-upload-button {
            background: #1e3a2f;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .file-input::-webkit-file-upload-button:hover {
            background: #2c5a3b;
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
                        <i class="fas fa-utensils text-green-700"></i>
                        Menu Management
                    </h1>
                    <p class="text-gray-500 mt-2">Manage your cafe menu items, add new products or remove existing ones</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 bg-white px-5 py-2.5 rounded-full shadow-sm">
                    <i class="fas fa-coffee text-green-600"></i>
                    <span class="font-medium">Total Menu: <span id="totalMenu">{{ $menus->count() ?? 0 }}</span></span>
                </div>
            </div>
        </div>

        <!-- FORM TAMBAH MENU (didesain ulang) -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center gap-2 mb-5">
                <i class="fas fa-plus-circle text-green-700 text-xl"></i>
                <h2 class="text-xl font-bold text-gray-800">Tambah Menu Baru</h2>
            </div>
            
            <form method="POST"
                  action="/admin/menu/store"
                  enctype="multipart/form-data"
                  class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag text-green-600 mr-1"></i> Nama Menu
                    </label>
                    <input type="text"
                           name="nama_menu"
                           placeholder="Contoh: Costa Coffee"
                           class="form-input w-full border border-gray-300 rounded-xl p-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-money-bill-wave text-green-600 mr-1"></i> Harga (Rp)
                    </label>
                    <input type="number"
                           name="harga"
                           placeholder="Contoh: 55000"
                           class="form-input w-full border border-gray-300 rounded-xl p-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image text-green-600 mr-1"></i> Gambar Menu
                    </label>
                    <input type="file"
                           name="image"
                           accept="image/*"
                           class="file-input w-full border border-gray-300 rounded-xl p-2 text-gray-600 bg-gray-50">
                </div>

                <div class="md:col-span-3">
                    <button class="bg-gradient-to-r from-[#1e3a2f] to-[#2c5a3b] hover:from-[#153728] hover:to-[#1f4735] text-white px-6 py-3 rounded-xl font-bold transition-all duration-200 flex items-center justify-center gap-2 shadow-md w-full md:w-auto">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Menu</span>
                    </button>
                </div>

            </form>
        </div>

        <!-- LIST MENU (grid dengan card modern) -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2">
                    <i class="fas fa-list-ul text-green-700 text-xl"></i>
                    <h2 class="text-xl font-bold text-gray-800">Daftar Menu</h2>
                </div>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i>
                    <span>Total {{ $menus->count() ?? 0 }} item menu</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach($menus as $index => $menu)
                <div class="menu-card bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-md overflow-hidden border border-gray-100" style="--item-index: {{ $index }}">
                    <!-- IMAGE SECTION -->
                    <div class="relative h-48 overflow-hidden">
                        @if($menu->image)
                            <img src="{{ asset('storage/'.$menu->image) }}"
                                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                 alt="{{ $menu->nama_menu }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-image text-5xl mb-2 opacity-50"></i>
                                <span class="text-sm">No Image</span>
                            </div>
                        @endif
                        
                        <!-- Badge kategori (opsional) -->
                        <div class="absolute top-3 right-3 bg-green-600 text-white text-xs px-2 py-1 rounded-full shadow-md">
                            <i class="fas fa-tag mr-1"></i> Menu
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $menu->nama_menu }}</h3>
                        <p class="text-green-600 font-bold text-xl mb-3">
                            Rp {{ number_format($menu->harga) }}
                        </p>
                        
                        <!-- Informasi tambahan -->
                        <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar-alt"></i>
                                ID: {{ $menu->id }}
                            </span>
                        </div>

                        <!-- DELETE BUTTON -->
                        <form method="POST"
                              action="/admin/menu/{{ $menu->id }}"
                              onsubmit="return confirm('Hapus menu {{ $menu->nama_menu }}?')"
                              class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white w-full py-2.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 font-medium shadow-sm">
                                <i class="fas fa-trash-alt"></i>
                                <span>Hapus Menu</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- Jika tidak ada menu -->
            @if($menus->isEmpty())
            <div class="text-center py-16">
                <i class="fas fa-utensils text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-400 text-lg">Belum ada menu. Silakan tambah menu terlebih dahulu.</p>
            </div>
            @endif

        </div>

    </div>

</div>

<script>
    // Update total menu count jika ada perubahan (opsional)
    function updateTotalMenu() {
        const menuCards = document.querySelectorAll('.menu-card');
        const totalSpan = document.getElementById('totalMenu');
        if (totalSpan && menuCards) {
            totalSpan.textContent = menuCards.length;
        }
    }
    
    // Jalankan saat halaman load
    document.addEventListener('DOMContentLoaded', function() {
        updateTotalMenu();
        
        // Animasi smooth scroll untuk form
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Biarkan form submit normal, hanya animasi kecil
                const btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';
                }
            });
        }
    });
</script>

</body>
</html>