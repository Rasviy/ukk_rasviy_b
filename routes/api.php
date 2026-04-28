<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\TransactionController;

Route::get('/menus', [MenuController::class, 'index']);
Route::post('/menus', [MenuController::class, 'store']);

Route::middleware('auth')->post('/transactions', [TransactionController::class, 'store']);