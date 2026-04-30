<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen User | CafeInAja</title>
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

        /* Card style - konsisten */
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

        /* Form input styles */
        .form-input {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            transition: all 0.2s;
            background: white;
            width: 100%;
        }

        .form-input:focus {
            outline: none;
            border-color: #2d6a4f;
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
        }

        .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            transition: all 0.2s;
            background: white;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
        }

        .form-select:focus {
            outline: none;
            border-color: #2d6a4f;
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3a2f 0%, #2d6a4f 100%);
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 50px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 47, 0.3);
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

        /* Badge roles */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-admin {
            background: #dcfce7;
            color: #166534;
        }

        .badge-kasir {
            background: #e0f2fe;
            color: #0284c7;
        }

        /* Avatar */
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

        /* Alert */
        .alert-success {
            background: #dcfce7;
            border-left: 4px solid #2d6a4f;
            color: #166534;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
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

            .form-grid {
                grid-template-columns: 1fr !important;
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

        /* Label style */
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-label i {
            margin-right: 6px;
            color: #2d6a4f;
        }
    </style>
</head>

<body>

    <div class="ml-64 p-6">
        <div class="max-w-7xl mx-auto">

            @include('admin.layouts.navbar')

            <!-- Header dengan tema hijau -->
            <div class="page-header">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="font-bold text-white text-2xl tracking-tight">Manajemen User</h1>
                                <p class="text-white/80 text-sm mt-0.5">Kelola akun admin dan kasir</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 text-white text-sm">
                        <i class="fas fa-user-plus"></i> Total User: {{ count($users) }}
                    </div>
                </div>
            </div>

            <!-- ALERT SUCCESS -->
            @if (session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- FORM TAMBAH USER -->
            <div class="card p-6 mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-[#1e3a2f] to-[#2d6a4f] rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-sm"></i>
                    </div>
                    <h2 class="font-bold text-gray-800 text-lg">Tambah User Baru</h2>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-4">
                        <ul class="text-sm">
                            @foreach ($errors->all() as $error)
                                <li>⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/admin/users" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf

                    <div>
                        <label class="form-label">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </label>
                        <input type="text" name="name" placeholder="Masukkan nama lengkap" class="form-input"
                            required>
                    </div>

                    <div>
                        <label class="form-label">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" name="email" placeholder="Masukkan email" class="form-input" required>
                    </div>

                    <div>
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" name="password" placeholder="Masukkan password" class="form-input"
                            required>
                    </div>

                    <div>
                        <label class="form-label">
                            <i class="fas fa-user-tag"></i> Role / Hak Akses
                        </label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">👑 Administrator</option>
                            <option value="kasir">💰 Kasir</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="btn-primary w-full md:w-auto px-8">
                            <i class="fas fa-save"></i> Tambah User
                        </button>
                    </div>
                </form>
            </div>

            <!-- LIST USER -->
            <div class="card overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-[#1e3a2f] to-[#2d6a4f] rounded-lg flex items-center justify-center">
                            <i class="fas fa-list text-white text-sm"></i>
                        </div>
                        <h2 class="font-bold text-gray-800 text-lg">Daftar User</h2>
                        <span class="ml-auto text-xs text-gray-400">
                            <i class="fas fa-database"></i> Total {{ count($users) }} user
                        </span>
                    </div>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-user-circle"></i> Nama
                                </th>
                                <th>
                                    <i class="fas fa-envelope"></i> Email
                                </th>
                                <th>
                                    <i class="fas fa-user-tag"></i> Role
                                </th>
                                <th>
                                    <i class="fas fa-cog"></i> Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                            @forelse($users as $u)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                {{ strtoupper(substr($u->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">
                                                    {{ $u->name }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    ID: #{{ $u->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                            <span>{{ $u->email }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $roleClass = $u->role == 'admin' ? 'badge-admin' : 'badge-kasir';
                                            $roleIcon = $u->role == 'admin' ? 'fa-crown' : 'fa-cash-register';
                                        @endphp
                                        <span class="badge {{ $roleClass }}">
                                            <i class="fas {{ $roleIcon }}"></i>
                                            {{ strtoupper($u->role) }}
                                        </span>
                                    </td>

                                    <!-- 🔥 INI DIA AKSI (PINDAH KE SINI) -->
                                    <td>
                                        <div class="flex gap-2">

                                            <!-- EDIT -->
                                            <button
                                                onclick="openEditModal(
                {{ $u->id }},
                '{{ addslashes($u->name) }}',
                '{{ $u->email }}',
                '{{ $u->role }}'
            )"
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- DELETE -->
                                            <form method="POST" action="/admin/users/{{ $u->id }}"
                                                onsubmit="return confirm('Yakin hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-users-slash"></i>
                                            <p class="text-gray-500">Belum ada user</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Info -->
                @if (count($users) > 0)
                    <div
                        class="border-t border-gray-100 px-6 py-4 bg-gray-50 flex justify-between items-center flex-wrap gap-3">
                        <div class="flex gap-4 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-chart-simple text-green-600"></i>
                                <span class="text-gray-600">Total User: <strong
                                        class="text-gray-800">{{ count($users) }}</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-shield text-green-600"></i>
                                <span class="text-gray-600">Admin: <strong
                                        class="text-gray-800">{{ $users->where('role', 'admin')->count() }}</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user text-blue-600"></i>
                                <span class="text-gray-600">Kasir: <strong
                                        class="text-gray-800">{{ $users->where('role', 'kasir')->count() }}</strong></span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400">
                            <i class="fas fa-clock"></i> Last updated: {{ now()->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-500 text-xs py-6 mt-4">
                <i class="fas fa-shield-alt"></i> Sistem manajemen user • CafeInAja Premium System
            </div>

        </div>
    </div>
    <div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-2xl w-[400px]">
            <h2 class="text-lg font-bold mb-4">Edit User</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" id="edit_id">

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" id="edit_name" name="name" class="w-full border p-2 rounded">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" id="edit_email" name="email" class="w-full border p-2 rounded">
                </div>

                <div class="mb-3">
                    <label>Password (opsional)</label>
                    <input type="password" name="password" class="w-full border p-2 rounded">
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select id="edit_role" name="role" class="w-full border p-2 rounded">
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-300 px-4 py-2 rounded w-full">
                        Batal
                    </button>
                    <button class="bg-green-600 text-white px-4 py-2 rounded w-full">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openEditModal(id, name, email, role) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;

            document.getElementById('editForm').action = '/admin/users/' + id;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>

</body>

</html>
