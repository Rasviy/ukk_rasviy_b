<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CafeInAja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Responsive breakpoints */
        @media (max-width: 1024px) {
            .menu-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        @media (max-width: 768px) {
            .flex.h-screen {
                flex-direction: column !important;
            }

            .w-2\/3,
            .w-1\/3 {
                width: 100% !important;
            }

            .menu-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .page-header {
                flex-direction: column !important;
                gap: 16px !important;
            }

            .search-section {
                width: 100% !important;
            }

            #search {
                width: 100% !important;
            }
        }

        @media (max-width: 480px) {
            .menu-grid {
                grid-template-columns: 1fr !important;
            }

            .cart-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px !important;
            }

            .modal-content {
                width: 95% !important;
                margin: 16px !important;
                padding: 20px !important;
            }

            .payment-methods {
                flex-direction: column !important;
            }
        }

        .menu-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .menu-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }

        .cat-btn {
            padding: 8px 24px;
            border-radius: 40px;
            background: #f1f5f9;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
            white-space: nowrap;
        }

        @media (max-width: 640px) {
            .cat-btn {
                padding: 6px 16px;
                font-size: 12px;
            }
        }

        .cat-btn.active {
            background: #2d3e2f;
            color: white;
        }

        .cart-item {
            background: #faf9f8;
            border-radius: 18px;
            padding: 12px;
            margin-bottom: 12px;
            border-left: 4px solid #2d6a4f;
        }

        .qty-control {
            background: white;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 4px 12px;
            border: 1px solid #e2e8f0;
        }

        .qty-control button {
            background: #f1f5f9;
            width: 28px;
            height: 28px;
            border-radius: 30px;
            font-weight: bold;
            transition: all 0.2s;
        }

        .qty-control button:active {
            transform: scale(0.95);
        }

        .payment-card {
            transition: all 0.2s;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .payment-card.active {
            border-color: #2d6a4f;
            background: #f0fdf4;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-content {
            animation: fadeIn 0.2s ease-out;
        }

        .menu-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        @media (max-width: 640px) {
            .menu-img {
                height: 150px;
            }
        }

        .menu-card:hover .menu-img {
            transform: scale(1.05);
        }

        /* Scroll behavior */
        .overflow-y-auto {
            scroll-behavior: smooth;
        }

        /* Customer name input style */
        .customer-input {
            transition: all 0.2s;
        }

        .customer-input:focus {
            border-color: #2d6a4f;
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden flex-col md:flex-row">

        <!-- LEFT PANEL - MENU -->
        <div class="w-full md:w-2/3 flex flex-col bg-white">
            <!-- Top Bar - Responsive -->
            <div
                class="bg-gradient-to-r from-[#1e3a2f] to-[#2d6a4f] text-white px-4 sm:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <i class="fas fa-mug-hot text-2xl"></i>
                    <h1 class="font-bold text-xl sm:text-2xl">CafeInAja</h1>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative flex-1 sm:flex-initial">
                        <i
                            class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input id="search" onkeyup="renderMenu()" placeholder="Cari menu..."
                            class="search-input pl-10 pr-4 py-2 rounded-full text-gray-800 w-full sm:w-80 bg-white/90 focus:outline-none focus:ring-2 focus:ring-amber-300">
                    </div>
                    <button onclick="handleLogout()"
                        class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-full transition flex items-center gap-2 text-sm sm:text-base">
                        <i class="fas fa-sign-out-alt"></i> <span class="hidden sm:inline">Logout</span>
                    </button>
                </div>
            </div>

            <!-- Menu Grid -->
            <div class="flex-1 overflow-y-auto px-4 sm:px-8 py-6">
                <div id="menu-list" class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 menu-grid">
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL - CART -->
        <div class="w-full md:w-1/3 bg-gray-50 flex flex-col shadow-xl">
            <div class="p-4 sm:p-5 border-b bg-white sticky top-0">
                <div class="flex items-center gap-2 cart-header">
                    <i class="fas fa-shopping-cart text-green-700 text-xl"></i>
                    <span class="font-bold text-xl">Keranjang</span>
                    <span class="ml-auto bg-gray-200 px-3 py-1 rounded-full text-sm" id="cart-count-badge">0 item</span>
                </div>

                <!-- Customer Name Input -->
                <div class="mt-4">
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">
                        <i class="fas fa-user"></i> Nama Pelanggan
                    </label>
                    <input type="text" id="customer-name" placeholder="Masukkan nama pelanggan..."
                        class="customer-input w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-green-500 transition"
                        autocomplete="off">
                </div>
            </div>

            <div id="cart" class="flex-1 overflow-y-auto p-4 space-y-3"></div>

            <div class="border-t p-4 sm:p-5 bg-white">
                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span class="font-bold">Rp <span id="subtotal">0</span></span>
                    </div>
                    <div class="flex justify-between mb-2 text-sm text-gray-600">
                        <span>Pajak (5%)</span>
                        <span>Rp <span id="tax">0</span></span>
                    </div>
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span class="text-green-700">Rp <span id="total">0</span></span>
                    </div>
                </div>
                <button onclick="openPaymentModal()"
                    class="w-full bg-green-800 hover:bg-green-900 text-white py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    <!-- PAYMENT MODAL - Responsive -->
    <div id="paymentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="modal-content bg-white rounded-2xl p-4 sm:p-6 w-full max-w-[450px] max-h-[90vh] overflow-y-auto">
            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-receipt text-green-700 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold">Pembayaran</h2>
            </div>

            <!-- Show Customer Name -->
            <div id="customer-info" class="bg-blue-50 rounded-xl p-3 mb-4 text-center">
                <p class="text-xs text-gray-600 mb-1">Pelanggan</p>
                <p class="font-semibold text-gray-800" id="modal-customer-name">-</p>
            </div>

            <div class="bg-green-50 rounded-xl p-4 text-center mb-5">
                <p class="text-sm text-gray-600">Total Tagihan</p>
                <p class="text-3xl font-bold text-green-700"><span id="modal-total">0</span></p>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-5 payment-methods">
                <div onclick="setPayment('cash')" id="payment-cash"
                    class="payment-card active bg-white rounded-xl p-3 text-center cursor-pointer">
                    <i class="fas fa-money-bill-wave text-2xl text-orange-500 mb-1"></i>
                    <p class="font-semibold">Tunai</p>
                </div>
                <div onclick="setPayment('qris')" id="payment-qris"
                    class="payment-card bg-white rounded-xl p-3 text-center cursor-pointer">
                    <i class="fas fa-qrcode text-2xl text-purple-500 mb-1"></i>
                    <p class="font-semibold">QRIS</p>
                </div>
            </div>

            <div id="cash-section">
                <label class="block text-sm font-semibold mb-2">Jumlah Uang</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2">Rp</span>
                    <input type="number" id="cash-input"
                        class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500"
                        placeholder="0" oninput="hitungKembalian()">
                </div>
                <div class="flex justify-between mt-2 text-sm">
                    <span>Kembalian:</span>
                    <span class="font-bold text-green-600">Rp <span id="kembalian">0</span></span>
                </div>
            </div>

            <div id="qris-section" class="hidden text-center">
                <img id="qris-image" class="mx-auto w-32 h-32 mb-2"
                    src="https://api.qrserver.com/v1/create-qr-code/?size=128x128&data=demo">
                <p class="text-xs text-gray-500">Scan QR Code untuk membayar</p>
            </div>

            <div class="flex gap-2 mt-5">
                <button onclick="closeModal()"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 py-2 rounded-lg transition">Batal</button>
                <button onclick="prosesBayar()"
                    class="flex-1 bg-green-800 hover:bg-green-900 text-white py-2 rounded-lg transition">Bayar</button>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let allMenus = [];
        let currentFilter = 'all';
        let selectedPayment = 'cash';
        let globalTotal = 0;

        // LOGOUT
        function handleLogout() {
            if (confirm('Logout sekarang?')) {
                let token = document.querySelector('meta[name="csrf-token"]').content;
                fetch('/logout', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    })
                    .then(() => window.location.href = '/login')
                    .catch(() => window.location.href = '/login');
            }
        }

        async function loadMenu() {
            try {
                let res = await fetch('/api/menus');
                let data = await res.json();
                allMenus = data;
            } catch (e) {
                // Fallback data
                allMenus = [{
                        id: 1,
                        nama_menu: "Iced Caramel Macchiato",
                        harga: 28000,
                        category: {
                            name: "minuman"
                        },
                        image: null
                    },
                    {
                        id: 2,
                        nama_menu: "New York Cheesecake",
                        harga: 32000,
                        category: {
                            name: "desert"
                        },
                        image: null
                    },
                    {
                        id: 3,
                        nama_menu: "Nasi Goreng Spesial",
                        harga: 45000,
                        category: {
                            name: "makanan"
                        },
                        image: null
                    },
                    {
                        id: 4,
                        nama_menu: "Matcha Latte",
                        harga: 26000,
                        category: {
                            name: "minuman"
                        },
                        image: null
                    },
                    {
                        id: 5,
                        nama_menu: "Chocolate Brownies",
                        harga: 24000,
                        category: {
                            name: "desert"
                        },
                        image: null
                    },
                    {
                        id: 6,
                        nama_menu: "Cappuccino",
                        harga: 22000,
                        category: {
                            name: "minuman"
                        },
                        image: null
                    },
                ];
            }
            renderMenu();
        }

        function renderMenu() {
            let search = document.getElementById('search').value.toLowerCase();
            let menus = [...allMenus];

            if (currentFilter !== 'all') {
                menus = menus.filter(m => {
                    let cat = (m.category?.name || '').toLowerCase();
                    if (currentFilter === 'minuman') return cat.includes('minuman') || cat === 'coffee' || cat ===
                        'beverage';
                    if (currentFilter === 'desert') return cat.includes('desert') || cat.includes('dessert');
                    if (currentFilter === 'makanan') return cat.includes('makanan') || cat.includes('food');
                    return cat.includes(currentFilter);
                });
            }

            if (search) {
                menus = menus.filter(m => m.nama_menu.toLowerCase().includes(search));
            }

            let html = '';
            menus.forEach(menu => {
                let imageUrl = menu.image;
                if (!imageUrl) {
                    let seed = encodeURIComponent(menu.nama_menu);
                    imageUrl = `https://placehold.co/400x400/2d6a4f/white?text=${seed.substring(0, 15)}`;
                }
                if (menu.image && !menu.image.startsWith('http')) {
                    imageUrl = `/storage/${menu.image}`;
                }

                html += `
                <div onclick="addToCart(${menu.id}, '${escapeHtml(menu.nama_menu)}', ${menu.harga})" 
                     class="menu-card cursor-pointer">
                    <div class="relative overflow-hidden" style="height: 180px;">
                        <img src="${imageUrl}" 
                             alt="${escapeHtml(menu.nama_menu)}"
                             class="menu-img w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='https://placehold.co/400x400/ffd166/2d6a4f?text=${escapeHtml(menu.nama_menu.substring(0,10))}'">
                    </div>
                    <div class="p-3">
                        <h3 class="font-semibold text-gray-800 text-sm sm:text-base">${escapeHtml(menu.nama_menu)}</h3>
                        <p class="text-green-700 font-bold mt-1 text-sm sm:text-base">${formatRupiah(menu.harga)}</p>
                        <button class="mt-2 text-xs bg-gray-100 px-3 py-1 rounded-full w-full hover:bg-gray-200 transition">
                            <i class="fas fa-plus"></i> Pesan
                        </button>
                    </div>
                </div>
            `;
            });

            document.getElementById('menu-list').innerHTML = html ||
                '<div class="col-span-full text-center py-20 text-gray-500">Menu tidak ditemukan</div>';
        }

        function addToCart(id, nama, harga) {
            let item = cart.find(i => i.menu_id === id);
            if (item) item.qty++;
            else cart.push({
                menu_id: id,
                nama: nama,
                harga: Number(harga),
                qty: 1
            });
            renderCart();

            // Visual feedback
            let btn = event.currentTarget;
            btn.style.transform = 'scale(0.98)';
            setTimeout(() => btn.style.transform = '', 200);
        }

        function removeItem(id) {
            cart = cart.filter(i => i.menu_id !== id);
            renderCart();
        }

        function minusQty(id) {
            let item = cart.find(i => i.menu_id === id);
            if (item) {
                item.qty--;
                if (item.qty <= 0) removeItem(id);
                renderCart();
            }
        }

        function plusQty(id) {
            let item = cart.find(i => i.menu_id === id);
            if (item) {
                item.qty++;
                renderCart();
            }
        }

        function renderCart() {
            let html = '';
            let subtotal = 0;

            cart.forEach(item => {
                let sub = item.harga * item.qty;
                subtotal += sub;
                html += `
                <div class="cart-item">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="font-bold text-sm sm:text-base">${escapeHtml(item.nama)}</div>
                            <div class="text-sm text-gray-600">${formatRupiah(item.harga)}</div>
                            <div class="qty-control mt-2">
                                <button onclick="minusQty(${item.menu_id})">−</button>
                                <span class="font-semibold">${item.qty}</span>
                                <button onclick="plusQty(${item.menu_id})">+</button>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-sm sm:text-base">${formatRupiah(sub)}</div>
                            <button onclick="removeItem(${item.menu_id})" class="text-red-500 text-xs mt-1">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            });

            if (cart.length === 0) {
                html = `<div class="text-center py-16 text-gray-400">
                        <i class="fas fa-shopping-cart text-5xl mb-3"></i>
                        <p>Keranjang kosong</p>
                    </div>`;
            }

            document.getElementById('cart').innerHTML = html;

            let tax = subtotal * 0.05; // 5% tax
            let total = subtotal + tax;

            document.getElementById('subtotal').innerText = formatRupiah(subtotal);
            document.getElementById('tax').innerText = formatRupiah(Math.floor(tax));
            document.getElementById('total').innerText = formatRupiah(Math.floor(total));

            let totalItems = cart.reduce((sum, i) => sum + i.qty, 0);
            document.getElementById('cart-count-badge').innerText = `${totalItems} item${totalItems !== 1 ? 's' : ''}`;
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        function escapeHtml(str) {
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function getCustomerName() {
            let name = document.getElementById('customer-name').value.trim();
            if (name === '') {
                name = 'Guest';
            }
            return name;
        }

        function openPaymentModal() {
            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            let customerName = getCustomerName();
            document.getElementById('modal-customer-name').innerText = customerName;

            let subtotal = cart.reduce((s, i) => s + i.harga * i.qty, 0);
            let total = Math.floor(subtotal + (subtotal * 0.05));
            globalTotal = total;

            document.getElementById('modal-total').innerText = formatRupiah(globalTotal);
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('paymentModal').classList.add('flex');
            setPayment('cash');
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('cash-input').value = '';
            document.getElementById('kembalian').innerText = '0';
        }

        function setPayment(type) {
            selectedPayment = type;

            if (type === 'cash') {
                document.getElementById('payment-cash').classList.add('active');
                document.getElementById('payment-qris').classList.remove('active');
                document.getElementById('cash-section').style.display = 'block';
                document.getElementById('qris-section').classList.add('hidden');
            } else {
                document.getElementById('payment-qris').classList.add('active');
                document.getElementById('payment-cash').classList.remove('active');
                document.getElementById('cash-section').style.display = 'none';
                document.getElementById('qris-section').classList.remove('hidden');

                let qrData = `PAY-${globalTotal}-${Date.now()}`;
                document.getElementById('qris-image').src =
                    `https://api.qrserver.com/v1/create-qr-code/?size=128x128&data=${qrData}`;
            }
        }

        function hitungKembalian() {
            let uang = Number(document.getElementById('cash-input').value || 0);
            let kembali = uang - globalTotal;
            document.getElementById('kembalian').innerText = kembali > 0 ? formatRupiah(kembali) : '0';
        }

        async function prosesBayar() {
            let uang = 0;
            let kembalian = 0;
            let customerName = getCustomerName();

            if (selectedPayment === 'cash') {
                uang = Number(document.getElementById('cash-input').value || 0);
                kembalian = uang - globalTotal;

                if (uang < globalTotal) {
                    alert('Uang kurang!');
                    return;
                }
            }

            let token = document.querySelector('meta[name="csrf-token"]').content;
            let subtotal = cart.reduce((s, i) => s + i.harga * i.qty, 0);
            let tax = subtotal * 0.05;

            try {
                let res = await fetch('/transactions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        items: cart,
                        subtotal: subtotal,
                        tax: tax,
                        total: globalTotal,
                        payment_method: selectedPayment,
                        uang_bayar: uang,
                        kembalian: kembalian > 0 ? kembalian : 0,
                        customer_name: document.getElementById('customer-name').value || 'Guest',
                    })
                });

                let text = await res.text();
                console.log("SERVER RESPONSE:", text);

                if (!res.ok) {
                    alert("Server Error:\n" + text);
                    return;
                }

                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    alert("Response bukan JSON! Cek backend");
                    return;
                }

                if (data.transaction_id) {
                    closeModal();
                    window.open('/struk/' + data.transaction_id, '_blank');
                    cart = [];
                    document.getElementById('customer-name').value = '';
                    renderCart();
                    alert('Pembayaran berhasil! Terima kasih sudah berbelanja.');
                } else {
                    alert(data.message || 'Transaksi gagal!');
                }

            } catch (error) {
                console.error(error);
                alert("Error sistem bro, cek console");
            }
        }

        loadMenu();
    </script>
</body>

</html>
