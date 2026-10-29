<?php

namespace Database\Factories;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalPinjam = fake()->dateTimeBetween('-1 month', 'now');
        $tanggalKembali = (clone $tanggalPinjam)->modify('+7 days');

        return [
            'kode_pinjam' => 'PINJ-'.strtoupper(Str::random(8)),
            'user_id' => User::factory(),
            'alat_id' => Alat::factory(),
            'jumlah' => fake()->numberBetween(1, 3),
            'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
            'tanggal_kembali' => $tanggalKembali->format('Y-m-d'),
            'status' => fake()->randomElement(['menunggu', 'disetujui', 'ditolak', 'selesai']),
        ];
    }
}
