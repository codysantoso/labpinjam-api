<?php

namespace Tests\Feature;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeminjamanApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_borrow_alat_and_stock_decrements(): void
    {
        $user = User::factory()->mahasiswa()->create();
        $alat = Alat::factory()->create(['stok' => 10]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/peminjamans', [
                'alat_id' => $alat->id,
                'jumlah' => 3,
                'tanggal_pinjam' => now()->toDateString(),
                'tanggal_kembali' => now()->addDays(5)->toDateString(),
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.jumlah', 3);

        $this->assertEquals(7, $alat->fresh()->stok);
        $this->assertDatabaseHas('peminjamans', [
            'user_id' => $user->id,
            'alat_id' => $alat->id,
            'jumlah' => 3,
            'status' => 'menunggu',
        ]);
    }

    public function test_user_cannot_borrow_exceeding_stock(): void
    {
        $user = User::factory()->mahasiswa()->create();
        $alat = Alat::factory()->create(['stok' => 2]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/peminjamans', [
                'alat_id' => $alat->id,
                'jumlah' => 5,
                'tanggal_pinjam' => now()->toDateString(),
                'tanggal_kembali' => now()->addDays(5)->toDateString(),
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false);

        // Stok tidak berubah
        $this->assertEquals(2, $alat->fresh()->stok);
    }

    public function test_user_cannot_view_other_users_peminjaman(): void
    {
        $user1 = User::factory()->mahasiswa()->create();
        $user2 = User::factory()->mahasiswa()->create();
        $peminjaman = Peminjaman::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2, 'sanctum')
            ->getJson("/api/v1/peminjamans/{$peminjaman->id}");

        $response->assertStatus(403);
    }

    public function test_admin_can_update_status_and_stock_is_restored_on_completion(): void
    {
        $admin = User::factory()->admin()->create();
        $alat = Alat::factory()->create(['stok' => 5]);
        $peminjaman = Peminjaman::factory()->create([
            'alat_id' => $alat->id,
            'jumlah' => 3,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->patchJson("/api/v1/peminjamans/{$peminjaman->id}/status", [
                'status' => 'selesai',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'selesai');

        // Stok bertambah kembali 5 + 3 = 8
        $this->assertEquals(8, $alat->fresh()->stok);
    }
}
