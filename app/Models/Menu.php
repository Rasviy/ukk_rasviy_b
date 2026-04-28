<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\TransactionDetail;

class Menu extends Model
{
    protected $fillable = [
        'nama_menu',
        'harga',
        'image',
        'category_id' // 🔥 wajib juga biar aman
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 🔥 PAKAI SATU RELASI SAJA
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}