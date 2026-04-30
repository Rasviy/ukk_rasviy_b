<!-- SIDEBAR NAVIGATION - VERSION WITH WHITE TEXT -->
<aside class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-[#1e3a2f] to-[#2c5a3b] shadow-2xl z-50">
    <div class="flex flex-col h-full">
        <div class="p-6 border-b border-white/20">
            <div class="flex items-center gap-3">
                <i class="fas fa-mug-hot text-white text-3xl"></i>
                <div>
                    <h1 class="text-white font-bold text-xl tracking-wide">CafeInAja</h1>
                    <p class="text-white/70 text-xs mt-1">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="/admin/dashboard" class="sidebar-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="fas fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>

            <a href="/admin/menu" class="sidebar-link {{ request()->is('admin/menu') ? 'active' : '' }}">
                <i class="fas fa-utensils w-5"></i>
                <span>Menu Items</span>
            </a>

            <a href="/admin/transactions"
                class="sidebar-link {{ request()->is('admin/transactions') ? 'active' : '' }}">
                <i class="fas fa-receipt w-5"></i>
                <span>Transaksi</span>
            </a>

            <a href="/admin/report" class="sidebar-link {{ request()->is('admin/report') ? 'active' : '' }}">
                <i class="fas fa-file-alt w-5"></i>
                <span>Laporan</span>
            </a>

            <a href="/admin/log-activity"
                class="sidebar-link {{ request()->is('admin/log-activity') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list w-5"></i>
                <span>Log Activity</span>
            </a>

            <a href="/admin/users" class="sidebar-link {{ request()->is('admin/users') ? 'active' : '' }}">
                <i class="fas fa-users w-5"></i>
                <span>Manajemen User</span>
            </a>
        </nav>


        <div class="p-4 border-t border-white/20">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-user text-white text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="text-white text-sm font-medium">Administrator</p>
                    <p class="text-white/60 text-xs">Admin</p>
                </div>
            </div>

            <form method="POST" action="/logout">
                @csrf
                <button
                    class="w-full bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.2s ease;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }

    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .sidebar-link.active {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .sidebar-link i {
        width: 20px;
        font-size: 16px;
    }
</style>
