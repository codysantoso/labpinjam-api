<?php

namespace Database\Factories;

use App\Models\Alat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Alat>
 */
class AlatFactory extends Factory
{
    protected $model = Alat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_alat' => 'LAB-'.fake()->unique()->numerify('###'),
            'nama_alat' => fake()->randomElement([
                'Arduino Uno R3',
                'ESP32 NodeMCU',
                'Digital Multimeter Sanwa',
                'Osiloskop Digital 100MHz',
                'Sensor Jarak HC-SR04',
                'Raspberry Pi 4 Model B',
                'Solder Station Quick 936A',
                'Power Supply DC 30V 5A',
            ]),
            'stok' => fake()->numberBetween(5, 25),
            'kondisi' => fake()->randomElement(['Baik', 'Sangat Baik', 'Cukup']),
        ];
    }
}
