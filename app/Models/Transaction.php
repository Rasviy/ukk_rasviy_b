<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionDetail;
use App\Models\User;

class Transaction extends Model
{
    protected $fillable = [
    'user_id',
    'tanggal',
    'total',
    'tax',
    'payment_method',
    'uang_bayar',
    'kembalian'
];

    public function details(){
    return $this->hasMany(TransactionDetail::class);
}

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function menu()
{
    return $this->belongsTo(Menu::class);
}
}