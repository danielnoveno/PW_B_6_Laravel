<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/user/count', [UserController::class, 'countUsers']);
Route::get('buku/admin', [BukuController::class, 'indexAdmin']);
Route::middleware('auth:sanctum')->group(function () {
    // Admin Routes
    Route::get('/admin/{id}', [AdminController::class, 'show']);
    Route::get('/admin', [AdminController::class, 'index']);
    Route::put('/admin/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/{id}', [AdminController::class, 'destroy']);
    Route::post('/admin/logout', [AdminController::class, 'logout']);

    // User Routes
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/user', [UserController::class, 'index']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/user/change-password', [UserController::class, 'changePassword']);
    Route::put('/admin/user/{id}', [UserController::class, 'updateAsAdmin']);

    // Buku Routes
    Route::get('buku', [BukuController::class, 'index']);
    Route::get('buku/{id}', [BukuController::class, 'show']);
    Route::post('buku', [BukuController::class, 'store']);
    Route::put('buku/{id}', [BukuController::class, 'update']);
    Route::delete('buku/{id}', [BukuController::class, 'destroy']);
    Route::get('/buku/isbn/{isbn}', [BukuController::class, 'getBookByISBN']);
    Route::put('/buku/isbn/{isbn}', [BukuController::class, 'updateByISBN']);
    Route::delete('/buku/isbn/{isbn}', [BukuController::class, 'destroyByISBN']);

    // Bookmark routes
    Route::get('bookmarks', [BookmarkController::class, 'index']);
    Route::post('bookmarks', [BookmarkController::class, 'store']);
    Route::get('bookmarks/{bookmark}', [BookmarkController::class, 'show']);
    Route::put('bookmarks/{bookmark}', [BookmarkController::class, 'update']);
    Route::delete('bookmarks/{bookmark}', [BookmarkController::class, 'destroy']);

    // Transaski routes
    Route::get('transaksi', [TransaksiController::class, 'index']);
    Route::post('transaksi', [TransaksiController::class, 'store']);
    Route::get('transaksi/{transaksi}', [TransaksiController::class, 'show']);
    Route::put('transaksi/{transaksi}', [TransaksiController::class, 'update']);
    Route::delete('transaksi/{transaksi}', [TransaksiController::class, 'destroy']);
    Route::resource('transaksi', TransaksiController::class);

    // Rekomendasi routes
    Route::get('rekomendasi', [RekomendasiController::class, 'index']);
    Route::post('rekomendasi', [RekomendasiController::class, 'store']);
    Route::get('rekomendasi/{id}', [RekomendasiController::class, 'show']);
    Route::put('rekomendasi/{id}', [RekomendasiController::class, 'update']);
    Route::delete('rekomendasi/{id}', [RekomendasiController::class, 'destroy']);

    // Rekomendasi routes
    Route::get('log-aktivitas', [LogAktivitasController::class, 'index']);
    Route::post('log-aktivitas', [LogAktivitasController::class, 'store']);
    Route::get('log-aktivitas/{id}', [LogAktivitasController::class, 'show']);
    Route::put('log-aktivitas/{id}', [LogAktivitasController::class, 'update']);
    Route::delete('log-aktivitas/{id}', [LogAktivitasController::class, 'destroy']);

    //Riwayat Routes
    Route::get('/riwayat', [RiwayatController::class, 'index']);
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show']);
    Route::post('/riwayat', [RiwayatController::class, 'store']);
    Route::put('/riwayat/{id}', [RiwayatController::class, 'update']);
    Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy']);
});

Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/register', [AdminController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
