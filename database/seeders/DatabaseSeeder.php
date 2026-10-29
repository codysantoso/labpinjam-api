<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin / Laboran
        $admin = User::firstOrCreate(
            ['email' => 'admin@kampus.ac.id'],
            [
                'name' => 'Admin Laboran',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Mahasiswa
        $mahasiswa = User::firstOrCreate(
            ['email' => 'mahasiswa@kampus.ac.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
            ]
        );

        // 3. Inventaris Alat Laboratorium
        $alat1 = Alat::firstOrCreate(
            ['kode_alat' => 'LAB-001'],
            [
                'nama_alat' => 'ESP32 DevKit V1 30 Pin',
                'stok' => 15,
                'kondisi' => 'Baik',
            ]
        );

        $alat2 = Alat::firstOrCreate(
            ['kode_alat' => 'LAB-002'],
            [
                'nama_alat' => 'Arduino Uno R3 Original',
                'stok' => 20,
                'kondisi' => 'Baik',
            ]
        );

        $alat3 = Alat::firstOrCreate(
            ['kode_alat' => 'LAB-003'],
            [
                'nama_alat' => 'Digital Storage Oscilloscope 100MHz',
                'stok' => 4,
                'kondisi' => 'Sangat Baik',
            ]
        );

        $alat4 = Alat::firstOrCreate(
            ['kode_alat' => 'LAB-004'],
            [
                'nama_alat' => 'Digital Multimeter True RMS Sanwa',
                'stok' => 10,
                'kondisi' => 'Baik',
            ]
        );

        // 4. Data Peminjaman Awal
        Peminjaman::firstOrCreate(
            ['kode_pinjam' => 'PINJ-DEMO001'],
            [
                'user_id' => $mahasiswa->id,
                'alat_id' => $alat1->id,
                'jumlah' => 2,
                'tanggal_pinjam' => now()->toDateString(),
                'tanggal_kembali' => now()->addDays(7)->toDateString(),
                'status' => 'disetujui',
            ]
        );
    }
}
