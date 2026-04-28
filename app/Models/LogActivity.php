<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LogActivity extends Model
{
    protected $fillable = ['user_id','aktivitas','waktu'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}