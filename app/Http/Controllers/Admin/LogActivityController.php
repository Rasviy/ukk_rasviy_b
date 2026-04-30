<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Models\User;

class LogActivityController extends Controller
{
    public function index(Request $request)
{
    $query = LogActivity::with('user');

    // FILTER TANGGAL
    if ($request->tanggal) {
        $query->whereDate('waktu', $request->tanggal);
    }

    // FILTER USER (pakai ID)
    if ($request->user_id) {
        $query->where('user_id', $request->user_id);
    }

    // FILTER AKTIVITAS
    if ($request->aktivitas) {
        $query->where('aktivitas', 'like', '%' . $request->aktivitas . '%');
    }

    $logs = $query->latest()->paginate(10);

    // 🔥 WAJIB ADA
    $users = User::orderBy('name')->get();

    return view('admin.log_activity', compact('logs', 'users'));
}
}