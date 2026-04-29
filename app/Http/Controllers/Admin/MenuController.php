<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu', compact('menus'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_menu' => 'required',
        'harga' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,png,jpeg'
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('menus', 'public');
    }

    Menu::create([
        'nama_menu'   => $request->nama_menu,
        'harga'       => $request->harga,
        'category_id' => 1, // FIX: wajib selalu ada
        'image'       => $imagePath
    ]);

    return redirect()->back()->with('success', 'Menu berhasil ditambahkan');
}

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // 🔥 optional: hapus file gambar juga
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Menu dihapus');
    }
}