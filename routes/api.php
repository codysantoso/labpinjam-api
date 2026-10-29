<?php

use App\Http\Controllers\Api\V1\AlatController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PeminjamanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - LabPinjam API (v1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // --- Public Authentication Routes ---
    Route::post('/register', [AuthController::class, 'register'])->name('api.v1.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.v1.login');

    // --- Public Alat / Catalog Routes ---
    Route::get('/alats', [AlatController::class, 'index'])->name('api.v1.alats.index');
    Route::get('/alats/{id}', [AlatController::class, 'show'])->name('api.v1.alats.show');

    // --- Protected Routes (Sanctum Bearer Token) ---
    Route::middleware('auth:sanctum')->group(function () {
        // Authenticated User Profile & Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.v1.logout');
        Route::get('/user', [AuthController::class, 'me'])->name('api.v1.user');
        Route::get('/me', [AuthController::class, 'me'])->name('api.v1.me');

        // Peminjaman (Mahasiswa & Admin)
        Route::get('/peminjamans', [PeminjamanController::class, 'index'])->name('api.v1.peminjamans.index');
        Route::post('/peminjamans', [PeminjamanController::class, 'store'])->name('api.v1.peminjamans.store');
        Route::get('/peminjamans/{id}', [PeminjamanController::class, 'show'])->name('api.v1.peminjamans.show');

        // --- Admin / Laboran Only Routes ---
        Route::middleware('role:admin')->group(function () {
            // Alat Management (CRUD)
            Route::post('/alats', [AlatController::class, 'store'])->name('api.v1.alats.store');
            Route::put('/alats/{id}', [AlatController::class, 'update'])->name('api.v1.alats.update');
            Route::delete('/alats/{id}', [AlatController::class, 'destroy'])->name('api.v1.alats.destroy');

            // Peminjaman Status & Deletion
            Route::put('/peminjamans/{id}', [PeminjamanController::class, 'updateStatus'])->name('api.v1.peminjamans.update');
            Route::patch('/peminjamans/{id}/status', [PeminjamanController::class, 'updateStatus'])->name('api.v1.peminjamans.update-status');
            Route::delete('/peminjamans/{id}', [PeminjamanController::class, 'destroy'])->name('api.v1.peminjamans.destroy');
        });
    });
});
