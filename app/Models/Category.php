<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Menu; // penting

class Category extends Model
{
    protected $fillable = ['nama_kategori'];

    public function menus(){
        return $this->hasMany(Menu::class);
    }
}