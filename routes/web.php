<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\QrisController;

// ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TransactionAdminController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// auth bawaan laravel (login, register, dll)
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |-------------------------
    | ROLE REDIRECT
    |-------------------------
    */
    Route::get('/redirect', function () {

        $user = auth()->user();

        return $user->role === 'admin'
            ? redirect('/admin/dashboard')
            : redirect('/kasir');
    });

    /*
    |-------------------------
    | KASIR
    |-------------------------
    */
    Route::get('/kasir', function () {
        return view('kasir');
    });

    Route::post('/transactions', [TransactionController::class, 'store']);

    /*
    |-------------------------
    | ADMIN AREA
    |-------------------------
    */
    Route::prefix('admin')->group(function () {

        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/chart-data', [DashboardController::class, 'chartData']);
        Route::get('/log-activity', [App\Http\Controllers\Admin\LogActivityController::class, 'index']);

        // menu
        // menu
        Route::get('/menu', [MenuController::class, 'index']);
        Route::post('/menu/store', [MenuController::class, 'store']);
        Route::delete('/menu/{id}', [MenuController::class, 'destroy']);
        Route::get('/menu/{id}/edit', [MenuController::class, 'edit']);
        Route::put('/menu/{id}', [MenuController::class, 'update']);

        // transaksi
        Route::get('/transactions', [TransactionAdminController::class, 'index']);
        Route::get('/transactions/{id}', [TransactionAdminController::class, 'show']);

        // report
        Route::get('/report', [ReportController::class, 'index']);
        Route::get('/report/pdf', [ReportController::class, 'exportPdf']);
    });

    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::resource('users', UserController::class);
    });

    /*
    |-------------------------
    | STRUK & QRIS
    |-------------------------
    */
    Route::get('/struk/{id}', [StrukController::class, 'show']);
    Route::get('/struk/{id}/pdf', [StrukController::class, 'pdf']);
    Route::get('/qris/{id}', [QrisController::class, 'show']);

    /*
    |-------------------------
    | LOGOUT
    |-------------------------
    */
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    /*
    |-------------------------
    | PROFILE
    |-------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
});
