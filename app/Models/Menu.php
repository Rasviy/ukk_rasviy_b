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
        'category_id',
        'stok'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}