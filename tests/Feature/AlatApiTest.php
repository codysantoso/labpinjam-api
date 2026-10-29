<?php

namespace Tests\Feature;

use App\Models\Alat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlatApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_view_alats_list(): void
    {
        Alat::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/alats');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_public_can_view_single_alat(): void
    {
        $alat = Alat::factory()->create(['nama_alat' => 'Oscilloscope']);

        $response = $this->getJson("/api/v1/alats/{$alat->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.nama_alat', 'Oscilloscope');
    }

    public function test_admin_can_create_alat(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/alats', [
                'kode_alat' => 'LAB-999',
                'nama_alat' => 'Function Generator 20MHz',
                'stok' => 5,
                'kondisi' => 'Baik',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.kode_alat', 'LAB-999');

        $this->assertDatabaseHas('alats', ['kode_alat' => 'LAB-999']);
    }

    public function test_mahasiswa_cannot_create_alat(): void
    {
        $mahasiswa = User::factory()->mahasiswa()->create();

        $response = $this->actingAs($mahasiswa, 'sanctum')
            ->postJson('/api/v1/alats', [
                'kode_alat' => 'LAB-999',
                'nama_alat' => 'Function Generator 20MHz',
                'stok' => 5,
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_alat(): void
    {
        $admin = User::factory()->admin()->create();
        $alat = Alat::factory()->create(['nama_alat' => 'Old Name', 'stok' => 5]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/v1/alats/{$alat->id}", [
                'nama_alat' => 'Updated Name',
                'stok' => 12,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.nama_alat', 'Updated Name')
            ->assertJsonPath('data.stok', 12);
    }

    public function test_admin_can_delete_alat(): void
    {
        $admin = User::factory()->admin()->create();
        $alat = Alat::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/v1/alats/{$alat->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('alats', ['id' => $alat->id]);
    }
}
