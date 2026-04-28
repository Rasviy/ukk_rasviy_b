<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS Cafe | Kasir Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
        
        .menu-card {
            transition: all 0.2s ease;
        }
        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }

        .cat-btn {
            padding: 8px 24px;
            border-radius: 40px;
            background: #f3f4f6;
            font-weight: 500;
            transition: all 0.2s;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .cat-btn i {
            margin-right: 8px;
            font-size: 0.9rem;
        }
        .cat-btn.active {
            background: #2c3e2f;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .cat-btn:hover:not(.active) {
            background: #e5e7eb;
        }

        .cart-item {
            background: #fafafa;
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 12px;
            transition: all 0.1s;
            border-left: 4px solid #2c3e2f;
        }

        .qty-control {
            background: white;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 4px 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        .qty-control button {
            background: #f1f5f9;
            width: 26px;
            height: 26px;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.1s;
        }
        .qty-control button:hover {
            background: #cbd5e1;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        /* Tombol logout */
        .logout-btn {
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 40px;
            transition: all 0.2s;
            font-weight: 500;
            backdrop-filter: blur(4px);
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.35);
            transform: scale(1.02);
        }

        /* Payment method card style */
        .payment-card {
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }
        .payment-card.active {
            border-color: #2c5a3b;
            background: #f0fdf4;
        }
        .payment-card:hover:not(.active) {
            background: #f9fafb;
            transform: translateY(-2px);
        }

        /* Modal animation */
        @keyframes modalFadeIn {
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
            animation: modalFadeIn 0.2s ease;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex h-screen overflow-hidden shadow-2xl">

    <!-- LEFT PANEL -->
    <div class="w-2/3 flex flex-col bg-gray-50">

        <!-- TOPBAR dengan tombol logout -->
        <div class="bg-gradient-to-r from-[#1e3a2f] to-[#2c5a3b] text-white px-8 py-5 flex justify-between items-center shadow-md">
            <div class="flex items-center gap-3">
                <i class="fas fa-mug-hot text-2xl"></i>
                <h1 class="font-bold text-2xl tracking-wide">CUMAcafe</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input id="search" onkeyup="renderMenu()"
                        placeholder="Search items here..."
                        class="pl-10 pr-4 py-2 rounded-full text-gray-800 w-72 bg-white/90 focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                </div>
                <button onclick="handleLogout()" class="logout-btn flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </div>
        </div>

        <!-- MENU GRID -->
        <div class="flex-1 overflow-y-auto px-8 py-6 bg-gray-50">
            <div id="menu-list"
                class="grid grid-cols-3 lg:grid-cols-4 gap-7 auto-rows-max"></div>
        </div>

        <!-- CATEGORY BUTTONS -->
        <div class="bg-white px-8 py-5 flex gap-5 border-t border-gray-200 shadow-inner">
            <button onclick="filterMenu('all', event)" class="cat-btn active">
                <i class="fas fa-"></i> Semua
            </button>
            <button onclick="filterMenu('minuman', event)" class="cat-btn">
                <i class="fas fa-coffee"></i> Coffee
            </button>
            <button onclick="filterMenu('minuman', event)" class="cat-btn">
                <i class="fas fa-mug-saucer"></i> Tea
            </button>
            <button onclick="filterMenu('desert', event)" class="cat-btn">
                <i class="fas fa-ice-cream"></i> Desserts
            </button>
        </div>

    </div>


    <!-- RIGHT PANEL: Checkout -->
    <div class="w-1/3 bg-white flex flex-col shadow-2xl relative">

        <div class="p-5 border-b bg-white sticky top-0 z-10">
            <div class="flex items-center gap-2">
                <i class="fas fa-shopping-bag text-green-700 text-xl"></i>
                <span class="font-bold text-xl text-gray-800">Checkout</span>
                <span class="ml-auto text-xs bg-gray-100 px-3 py-1 rounded-full text-gray-600" id="cart-count-badge">0 item</span>
            </div>
        </div>

        <!-- CART LIST -->
        <div id="cart" class="flex-1 overflow-y-auto p-5 space-y-3 bg-gray-50/30"></div>

        <!-- TOTAL DAN PEMBAYARAN -->
        <div class="border-t border-gray-200 p-5 bg-white shadow-inner">

            <!-- RINGKASAN -->
            <div class="bg-gray-50 rounded-2xl p-4 mb-5">
                <div class="summary-row text-gray-600">
                    <span>Sub Total</span>
                    <span class="font-mono font-semibold">Rp <span id="subtotal">0</span></span>
                </div>
                <div class="summary-row text-gray-500 text-sm border-b border-dashed pb-2 mb-2">
                    <span>Tax (5%)</span>
                    <span class="font-mono">Rp <span id="tax">0</span></span>
                </div>
                <div class="summary-row text-lg font-bold text-gray-800 mt-1">
                    <span>Total</span>
                    <span class="text-green-700 text-xl">Rp <span id="total">0</span></span>
                </div>
            </div>

            <!-- Tombol Bayar -->
            <button onclick="openPaymentModal()"
                class="w-full bg-gradient-to-r from-[#1e3a2f] to-[#2c5a3b] hover:from-[#153728] hover:to-[#1f4735] text-white py-3.5 rounded-2xl font-bold text-lg shadow-lg transition duration-200 flex items-center justify-center gap-3">
                <i class="fas fa-receipt"></i> Bayar Sekarang
            </button>

            <!-- Cancel & Hold Order -->
            <div class="flex gap-3 mt-4 text-sm text-center">
                <div class="flex-1 bg-gray-100 rounded-xl py-2 text-gray-500 cursor-pointer hover:bg-gray-200 transition" onclick="if(cart.length>0){let sure=confirm('Cancel order?'); if(sure) {cart=[]; renderCart();}}else{alert('Keranjang kosong')}">
                    <i class="fas fa-times-circle"></i> Cancel Order
                </div>
                <div class="flex-1 bg-gray-100 rounded-xl py-2 text-gray-500 cursor-pointer hover:bg-gray-200 transition" onclick="if(cart.length>0){alert('Order disimpan sementara (Hold)');}else{alert('Tidak ada pesanan')}">
                    <i class="fas fa-pause-circle"></i> Hold Order
                </div>
            </div>
        </div>

    </div>

    <!-- PAYMENT MODAL (RINGKAS & SIMPLE) -->
    <div id="paymentModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="modal-content bg-white rounded-2xl p-6 w-[400px] max-w-[90%] shadow-2xl">
            
            <!-- Header Modal -->
            <div class="text-center mb-4">
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-credit-card text-green-700 text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Pembayaran</h2>
            </div>

            <!-- Total Harga -->
            <div class="bg-green-50 rounded-xl p-3 text-center mb-4">
                <p class="text-gray-600 text-xs mb-1">Total yang harus dibayar</p>
                <h3 class="text-2xl font-bold text-green-700">
                     <span id="modal-total">0</span>
                </h3>
            </div>

            <!-- METHOD PEMBAYARAN -->
            <div class="grid grid-cols-2 gap-3 mb-4">
                <!-- Cash Card -->
                <div onclick="setPayment('cash')" id="payment-cash" class="payment-card active bg-white rounded-xl p-3 text-center cursor-pointer border-2 border-green-600">
                    <i class="fas fa-money-bill-wave text-orange-500 text-2xl mb-1 block"></i>
                    <p class="font-bold text-gray-800 text-sm">Cash</p>
                </div>
                
                <!-- QRIS Card -->
                <div onclick="setPayment('qris')" id="payment-qris" class="payment-card bg-white rounded-xl p-3 text-center cursor-pointer border-2 border-transparent">
                    <i class="fas fa-qrcode text-purple-500 text-2xl mb-1 block"></i>
                    <p class="font-bold text-gray-800 text-sm">QRIS</p>
                </div>
            </div>

            <!-- CASH SECTION -->
            <div id="cash-section" class="mb-4">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Jumlah Uang</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                    <input type="number" id="cash-input"
                        class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500 text-sm"
                        placeholder="0"
                        oninput="hitungKembalian()">
                </div>
                <div class="flex justify-between mt-2 text-sm">
                    <span class="text-gray-600">Kembalian:</span>
                    <span class="font-bold text-green-600"> <span id="kembalian">0</span></span>
                </div>
            </div>

            <!-- QRIS SECTION (SIMPLE & RINGKAS) -->
            <div id="qris-section" class="hidden text-center">
                <div class="bg-gray-50 rounded-lg p-3">
                    <img id="qris-image"
                        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=demo"
                        class="mx-auto mb-2 w-32 h-32">
                    <p class="text-xs text-gray-500">Scan QR Code</p>
                </div>
            </div>

            <!-- BUTTON ACTION -->
            <div class="flex gap-2 mt-4">
                <button onclick="closeModal()"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg text-sm font-semibold transition">
                    Batal
                </button>
                <button onclick="prosesBayar()"
                    class="flex-1 bg-gradient-to-r from-[#1e3a2f] to-[#2c5a3b] hover:from-[#153728] hover:to-[#1f4735] text-white py-2 rounded-lg text-sm font-semibold transition shadow-md">
                    Bayar
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    /* STATE */
    let cart = [];
    let allMenus = [];
    let currentFilter = 'all';
    let selectedPayment = 'cash';
    let globalTotal = 0;

    /* FUNGSI LOGOUT */
    function handleLogout() {
        if (confirm('Apakah Anda yakin ingin logout?')) {
            let token = document.querySelector('meta[name="csrf-token"]').content;
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            }).then(() => {
                window.location.href = '/login';
            }).catch(() => {
                alert('Logout berhasil!');
                window.location.href = '/login';
            });
        }
    }

    /* LOAD MENU */
    async function loadMenu() {
        try {
            let res = await fetch('/api/menus');
            allMenus = await res.json();
            renderMenu();
        } catch(e) {
            allMenus = [
                { id: 1, nama_menu: "Matcha Late", harga: 20000, category: { name: "minuman" }, image: null },
                { id: 2, nama_menu: "Cheesecake", harga: 25000, category: { name: "desert" }, image: null },
                { id: 3, nama_menu: "Brownies", harga: 22000, category: { name: "desert" }, image: null },
                { id: 4, nama_menu: "Cappuccino", harga: 20000, category: { name: "minuman" }, image: null },
                { id: 5, nama_menu: "Lemon Pie", harga: 24000, category: { name: "desert" }, image: null },
                { id: 6, nama_menu: "Espresso", harga: 21000, category: { name: "minuman" }, image: null },
                { id: 7, nama_menu: "Jasmine Tea", harga: 18000, category: { name: "minuman" }, image: null },
            ];
            renderMenu();
        }
    }

    function filterMenu(type, e) {
        currentFilter = type;
        document.querySelectorAll('.cat-btn').forEach(btn => btn.classList.remove('active'));
        e.target.classList.add('active');
        renderMenu();
    }

    function renderMenu() {
        let search = document.getElementById('search').value.toLowerCase();
        let menus = allMenus;

        if (currentFilter !== 'all') {
            menus = menus.filter(m => {
                let catName = (m.category?.name ?? '').toLowerCase();
                if (currentFilter === 'minuman') return catName.includes('minuman') || catName === 'beverages' || catName === 'coffee';
                if (currentFilter === 'desert') return catName.includes('desert') || catName.includes('desserts');
                return catName.includes(currentFilter);
            });
        }

        if (search) {
            menus = menus.filter(m => m.nama_menu.toLowerCase().includes(search));
        }

        let html = '';
        menus.forEach(m => {
            let imageUrl = m.image ? `/storage/${m.image}` : null;
            let iconClass = "fas fa-coffee";
            if (m.nama_menu.toLowerCase().includes('tea')) iconClass = "fas fa-leaf";
            if (m.nama_menu.toLowerCase().includes('cheese')) iconClass = "fas fa-cake";
            if (m.nama_menu.toLowerCase().includes('brownies')) iconClass = "fas fa-chocolate-bar";
            
            let imgHtml = '';
            if (imageUrl) {
                imgHtml = `<img src="${imageUrl}" class="h-28 w-full object-cover rounded-xl shadow-sm">`;
            } else {
                imgHtml = `<div class="h-28 w-full bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl flex items-center justify-center text-3xl text-amber-700"><i class="${iconClass}"></i></div>`;
            }
            
            let priceFormatted = formatRupiah(m.harga);
            html += `
            <div onclick="addToCart(${m.id}, \`${escapeHtml(m.nama_menu)}\`, ${m.harga})"
                class="menu-card bg-white rounded-xl p-3 text-center shadow cursor-pointer w-full transform transition hover:shadow-lg border border-gray-100">
                ${imgHtml}
                <div class="mt-2 font-semibold text-gray-800 text-sm">${escapeHtml(m.nama_menu)}</div>
                <div class="text-green-700 font-bold text-sm mt-1">
                    ${priceFormatted}
                </div>
                <div class="text-xs text-gray-400 mt-1"><i class="fas fa-hand-point-left"></i> tap to order</div>
            </div>`;
        });
        document.getElementById('menu-list').innerHTML = html || '<div class="col-span-full text-center py-20 text-gray-400">Tidak ada menu ditemukan</div>';
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    function escapeHtml(str) {
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function addToCart(id, nama, harga) {
        let item = cart.find(i => i.menu_id === id);
        if (item) item.qty++;
        else cart.push({ menu_id: id, nama: nama, harga: Number(harga), qty: 1 });
        renderCart();
    }

    function removeItem(id) {
        cart = cart.filter(i => i.menu_id !== id);
        renderCart();
    }

    function minusQty(id) {
        let item = cart.find(i => i.menu_id === id);
        if (!item) return;
        item.qty--;
        if (item.qty <= 0) removeItem(id);
        renderCart();
    }

    function plusQty(id) {
        let item = cart.find(i => i.menu_id === id);
        if (item) item.qty++;
        renderCart();
    }

    function renderCart() {
        let html = '';
        let subtotal = 0;
        cart.forEach(item => {
            let sub = item.harga * item.qty;
            subtotal += sub;
            html += `
            <div class="cart-item flex justify-between items-center">
                <div class="flex-1">
                    <div class="font-bold text-gray-800 text-sm">${escapeHtml(item.nama)}</div>
                    <div class="text-xs text-gray-500">${formatRupiah(item.harga)}</div>
                    <div class="qty-control mt-1">
                        <button onclick="minusQty(${item.menu_id})" class="text-gray-700 font-bold">−</button>
                        <span class="font-semibold text-gray-800 text-sm">${item.qty}</span>
                        <button onclick="plusQty(${item.menu_id})" class="text-green-700 font-bold">+</button>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-gray-800 text-sm">${formatRupiah(sub)}</div>
                    <button onclick="removeItem(${item.menu_id})" class="text-red-400 text-xs hover:text-red-600"><i class="far fa-trash-alt"></i></button>
                </div>
            </div>`;
        });

        if (cart.length === 0) {
            html = `<div class="flex flex-col items-center justify-center py-16 text-gray-400"><i class="fas fa-shopping-cart text-5xl mb-3 opacity-40"></i><span class="text-sm">Keranjang kosong</span></div>`;
        }

        document.getElementById('cart').innerHTML = html;
        
        let taxVal = subtotal * 0.05;
        let totalVal = subtotal + taxVal;
        document.getElementById('subtotal').innerText = formatRupiah(subtotal);
        document.getElementById('tax').innerText = formatRupiah(Math.floor(taxVal));
        document.getElementById('total').innerText = formatRupiah(Math.floor(totalVal));
        
        let totalItems = cart.reduce((sum, i) => sum + i.qty, 0);
        document.getElementById('cart-count-badge').innerText = totalItems + ' item' + (totalItems !== 1 ? 's' : '');
    }

    /* OPEN MODAL */
    function openPaymentModal() {
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }

        let subtotal = cart.reduce((s, i) => s + i.harga * i.qty, 0);
        let tax = subtotal * 0.05;
        globalTotal = Math.floor(subtotal + tax);

        document.getElementById('modal-total').innerText = formatRupiah(globalTotal);
        document.getElementById('paymentModal').classList.remove('hidden');
        document.getElementById('paymentModal').classList.add('flex');

        setPayment('cash');
    }

    /* CLOSE MODAL */
    function closeModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        document.getElementById('cash-input').value = '';
        document.getElementById('kembalian').innerText = '0';
    }

    /* SET PAYMENT */
    function setPayment(type) {
        selectedPayment = type;

        const cashCard = document.getElementById('payment-cash');
        const qrisCard = document.getElementById('payment-qris');
        
        if (type === 'cash') {
            cashCard.classList.add('active', 'border-green-600');
            cashCard.classList.remove('border-transparent');
            qrisCard.classList.remove('active', 'border-green-600');
            qrisCard.classList.add('border-transparent');
            document.getElementById('cash-section').style.display = 'block';
            document.getElementById('qris-section').classList.add('hidden');
        } else {
            qrisCard.classList.add('active', 'border-green-600');
            qrisCard.classList.remove('border-transparent');
            cashCard.classList.remove('active', 'border-green-600');
            cashCard.classList.add('border-transparent');
            document.getElementById('cash-section').style.display = 'none';
            document.getElementById('qris-section').classList.remove('hidden');

            // QR kecil & simple
            let qrData = `PAY-${globalTotal}-${Date.now()}`;
            document.getElementById('qris-image').src =
                `https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=${qrData}`;
        }
    }

    /* HITUNG KEMBALIAN */
    function hitungKembalian() {
        let uang = Number(document.getElementById('cash-input').value || 0);
        let kembali = uang - globalTotal;
        document.getElementById('kembalian').innerText = kembali > 0 ? formatRupiah(kembali) : 'Rp 0';
    }

    /* PROSES BAYAR */
    async function prosesBayar() {

    let uang = 0;
    let kembalian = 0;

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
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                items: cart,
                subtotal: subtotal,
                tax: tax,
                total: globalTotal,
                payment_method: selectedPayment,
                uang_bayar: uang,
                kembalian: kembalian > 0 ? kembalian : 0
            })
        });

        // 🔥 DEBUG BIAR GA ERROR JSON
        let text = await res.text();
        console.log(text);

        let data = JSON.parse(text);

        if (!data.transaction_id) {
            alert('Transaksi gagal');
            return;
        }

        closeModal();

        closeModal();

// SEMUA metode bayar langsung ke struk
window.open('/struk/' + data.transaction_id, '_blank');

cart = [];
renderCart();

        cart = [];
        renderCart();

    } catch (error) {
        console.error(error);
        alert("Error sistem, cek console bro");
    }
}

    loadMenu();
</script>

</body>
</html>