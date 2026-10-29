<?php

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $totalAlat = 0;
    $totalPeminjaman = 0;
    $totalUser = 0;

    try {
        if (Schema::hasTable('alats')) {
            $totalAlat = Alat::count();
            $totalPeminjaman = Peminjaman::count();
            $totalUser = User::count();
        }
    } catch (Throwable) {
        // Fallback
    }

    return view('welcome', compact('totalAlat', 'totalPeminjaman', 'totalUser'));
});
