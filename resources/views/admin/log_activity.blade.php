<!DOCTYPE html>
<html>

<head>
    <title>Log Activity | CafeInAja</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f0fdf4;
            background-attachment: fixed;
        }

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
            background: #2d6a4f;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #1e3a2f;
        }

        /* Card style - konsisten dengan POS */
        .card {
            background: white;
            border-radius: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }

        /* Header gradient hijau */
        .page-header {
            background: linear-gradient(135deg, #1e3a2f 0%, #2d6a4f 100%);
            border-radius: 28px;
            padding: 24px 32px;
            margin-bottom: 32px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Filter inputs */
        .filter-input {
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 10px 20px;
            transition: all 0.2s;
            background: white;
        }

        .filter-input:focus {
            outline: none;
            border-color: #2d6a4f;
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
        }

        .filter-btn {
            padding: 10px 28px;
            border-radius: 50px;
            background: linear-gradient(135deg, #1e3a2f 0%, #2d6a4f 100%);
            color: white;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 47, 0.3);
        }

        .reset-btn {
            padding: 10px 28px;
            border-radius: 50px;
            background: #64748b;
            color: white;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .reset-btn:hover {
            background: #475569;
            transform: translateY(-2px);
        }

        /* Table styles */
        .table-container {
            overflow-x: auto;
            border-radius: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead tr {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .data-table th {
            padding: 16px 16px;
            text-align: left;
            font-weight: 700;
            color: #1e3a2f;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            font-size: 13px;
        }

        .data-table tbody tr {
            transition: all 0.2s;
        }

        .data-table tbody tr:hover {
            background: #f0fdf4;
        }

        /* Badge styles - tema hijau */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-info {
            background: #e0f2fe;
            color: #0284c7;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fed7aa;
            color: #9a3412;
        }

        .badge-transaction {
            background: #d1fae5;
            color: #065f46;
        }

        /* Avatar hijau */
        .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #1e3a2f 0%, #2d6a4f 100%);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        /* Pagination */
        .pagination-container {
            margin-top: 24px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            padding: 8px 14px;
            background: white;
            border-radius: 10px;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
        }

        .pagination .page-link:hover {
            background: #1e3a2f;
            color: white;
            transform: translateY(-2px);
        }

        .pagination .active .page-link {
            background: #2d6a4f;
            color: white;
            border-color: transparent;
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

        .card {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* Sidebar adjustment */
        .ml-64 {
            margin-left: 16rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .ml-64 {
                margin-left: 0;
            }

            .filter-form {
                flex-direction: column;
            }

            .filter-form input,
            .filter-form button,
            .filter-form a {
                width: 100%;
            }

            .page-header {
                padding: 20px;
            }

            .data-table th,
            .data-table td {
                padding: 10px 12px;
                font-size: 11px;
            }
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
            color: #2d6a4f;
        }

        /* Select styling */
        select.filter-input {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }
    </style>
</head>

<body>

    @include('admin.layouts.navbar')

    <div class="ml-64 p-6">
        <div class="max-w-7xl mx-auto">

            <!-- Header dengan tema hijau -->
            <div class="page-header">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-history text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="font-bold text-white text-2xl tracking-tight">Log Activity</h1>
                                <p class="text-white/80 text-sm mt-0.5">Monitoring aktivitas sistem dan transaksi</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 text-white text-sm">
                        <i class="fas fa-chart-line"></i> Real-time monitoring
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card p-6 mb-6">
                <form method="GET" class="filter-form flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-semibold text-gray-600 mb-2">
                            <i class="fas fa-calendar-alt"></i> Filter Tanggal
                        </label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="filter-input w-full">
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <select name="user_id" class="filter-input w-full">
                            <option value="">Semua User</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-semibold text-gray-600 mb-2">
                            <i class="fas fa-tag"></i> Jenis Aktivitas
                        </label>
                        <select name="aktivitas" class="filter-input w-full">
                            <option value="">Semua Aktivitas</option>
                            <option value="transaksi" {{ request('aktivitas') == 'transaksi' ? 'selected' : '' }}>💰
                                Transaksi</option>
                            <option value="login" {{ request('aktivitas') == 'login' ? 'selected' : '' }}>🔐 Login
                            </option>
                            <option value="logout" {{ request('aktivitas') == 'logout' ? 'selected' : '' }}>🚪 Logout
                            </option>
                            <option value="create" {{ request('aktivitas') == 'create' ? 'selected' : '' }}>📝 Create
                                Data</option>
                            <option value="update" {{ request('aktivitas') == 'update' ? 'selected' : '' }}>✏️ Update
                                Data</option>
                            <option value="delete" {{ request('aktivitas') == 'delete' ? 'selected' : '' }}>🗑️ Delete
                                Data</option>
                        </select>
                    </div> --}}

                    <div class="flex gap-2">
                        <button type="submit" class="filter-btn">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ request()->url() }}" class="reset-btn inline-flex items-center gap-2">
                            <i class="fas fa-undo-alt"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabel Log Activity -->
            <div class="card overflow-hidden">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 20%">
                                    <i class="fas fa-user-circle"></i> Pengguna
                                </th>
                                <th style="width: 25%">
                                    <i class="fas fa-clipboard-list"></i> Aktivitas
                                </th>
                                <th style="width: 20%">
                                    <i class="fas fa-clock"></i> Waktu
                                </th>
                                <th style="width: 35%">
                                    <i class="fas fa-info-circle"></i> Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                {{ strtoupper(substr($log->user->name ?? 'Guest', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">
                                                    {{ $log->user->name ?? 'Unknown User' }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    ID: #{{ $log->user_id ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $activityClass = 'badge-info';
                                            $activityIcon = 'fa-info-circle';

                                            if (str_contains(strtolower($log->aktivitas), 'login')) {
                                                $activityClass = 'badge-success';
                                                $activityIcon = 'fa-sign-in-alt';
                                            }
                                            if (str_contains(strtolower($log->aktivitas), 'logout')) {
                                                $activityClass = 'badge-warning';
                                                $activityIcon = 'fa-sign-out-alt';
                                            }
                                            if (str_contains(strtolower($log->aktivitas), 'transaksi')) {
                                                $activityClass = 'badge-transaction';
                                                $activityIcon = 'fa-receipt';
                                            }
                                            if (str_contains(strtolower($log->aktivitas), 'create')) {
                                                $activityClass = 'badge-success';
                                                $activityIcon = 'fa-plus-circle';
                                            }
                                            if (str_contains(strtolower($log->aktivitas), 'update')) {
                                                $activityClass = 'badge-info';
                                                $activityIcon = 'fa-edit';
                                            }
                                            if (str_contains(strtolower($log->aktivitas), 'delete')) {
                                                $activityClass = 'badge-warning';
                                                $activityIcon = 'fa-trash-alt';
                                            }
                                        @endphp
                                        <span class="badge {{ $activityClass }}">
                                            <i class="fas {{ $activityIcon }}"></i>
                                            {{ $log->aktivitas }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar-day text-gray-400 text-xs"></i>
                                            <span
                                                class="text-sm">{{ \Carbon\Carbon::parse($log->waktu)->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <i class="fas fa-clock text-gray-400 text-xs"></i>
                                            <span
                                                class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->waktu)->format('H:i:s') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if (isset($log->detail) && $log->detail)
                                            <div class="flex items-start gap-2">
                                                <i class="fas fa-file-alt text-gray-400 text-xs mt-0.5"></i>
                                                <span
                                                    class="text-xs text-gray-600">{{ Str::limit($log->detail, 60) }}</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-history"></i>
                                            <p class="text-gray-500">Belum ada log activity</p>
                                            <p class="text-xs text-gray-400 mt-2">Aktivitas akan muncul disini setelah
                                                ada transaksi atau login</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Statistik Footer -->
                @if (count($logs) > 0)
                    <div
                        class="border-t border-gray-100 px-6 py-4 bg-gray-50 flex justify-between items-center flex-wrap gap-3">
                        <div class="flex gap-4 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-chart-simple text-green-600"></i>
                                <span class="text-gray-600">Total Log: <strong
                                        class="text-gray-800">{{ $logs->total() }}</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-week text-green-600"></i>
                                <span class="text-gray-600">Halaman: <strong
                                        class="text-gray-800">{{ $logs->currentPage() }} /
                                        {{ $logs->lastPage() }}</strong></span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400">
                            <i class="fas fa-database"></i> Data terbaru
                        </div>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if (count($logs) > 0)
                <div class="pagination-container">
                    {{ $logs->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            @endif

            <!-- Footer -->
            <div class="text-center text-gray-500 text-xs py-6 mt-4">
                <i class="fas fa-shield-alt"></i> Sistem monitoring aktivitas • CafeInAja Premium System
            </div>

        </div>
    </div>

</body>

</html>
