<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index(){
        return Menu::with('category')->get();
    }

    public function store(Request $request){
        $data = $request->validate([
            'nama_menu'=>'required',
            'harga'=>'required|integer',
            'category_id'=>'required'
        ]);

        return Menu::create($data);
    }
}
