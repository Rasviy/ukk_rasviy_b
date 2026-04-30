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
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'nama_menu'   => $request->nama_menu,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'category_id' => 1,
            'image'       => $imagePath
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Menu dihapus');
    }
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu', 'public');
            $menu->image = $path;
        }

        $menu = Menu::findOrFail($id);

    $menu->update([
        'nama_menu' => $request->nama_menu,
        'harga' => $request->harga,
        'stok' => $request->stok,
    ]);

    return redirect()->back()->with('success', 'Menu berhasil diupdate');
}
}
