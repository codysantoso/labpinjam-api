<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Peminjaman\StorePeminjamanRequest;
use App\Http\Requests\Api\V1\Peminjaman\UpdateStatusRequest;
use App\Http\Resources\Api\V1\PeminjamanResource;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman.
     * Mahasiswa hanya melihat riwayat miliknya, Admin melihat seluruhnya.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $user = $request->user();

        $query = Peminjaman::with(['user', 'alat'])->latest('id');

        if (! $user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        return PeminjamanResource::collection($query->get());
    }

    /**
     * Mengajukan peminjaman alat laboratorium baru.
     */
    public function store(StorePeminjamanRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        return DB::transaction(function () use ($validated, $user) {
            $alat = Alat::lockForUpdate()->find($validated['alat_id']);

            if (! $alat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alat tidak ditemukan',
                ], 404);
            }

            if ($alat->stok < $validated['jumlah']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok alat tidak mencukupi untuk dipinjam',
                ], 422);
            }

            // Kurangi stok alat secara atomik
            $alat->decrement('stok', $validated['jumlah']);

            $peminjaman = Peminjaman::create([
                'kode_pinjam' => 'PINJ-'.strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'alat_id' => $alat->id,
                'jumlah' => $validated['jumlah'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'menunggu',
            ]);

            $peminjaman->load(['user', 'alat']);

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan peminjaman berhasil dibuat',
                'data' => new PeminjamanResource($peminjaman),
            ], 201);
        });
    }

    /**
     * Menampilkan detail satu peminjaman.
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $peminjaman = Peminjaman::with(['user', 'alat'])->find($id);

        if (! $peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan',
            ], 404);
        }

        $user = $request->user();
        if (! $user->isAdmin() && $peminjaman->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda tidak memiliki izin melihat data ini.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => new PeminjamanResource($peminjaman),
        ], 200);
    }

    /**
     * Memperbarui status peminjaman (Khusus Admin/Laboran).
     */
    public function updateStatus(UpdateStatusRequest $request, int $id): JsonResponse
    {
        $peminjaman = Peminjaman::with('alat')->find($id);

        if (! $peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan',
            ], 404);
        }

        $oldStatus = $peminjaman->status;
        $newStatus = $request->validated('status');

        DB::transaction(function () use ($peminjaman, $oldStatus, $newStatus) {
            // Jika status berubah ke 'ditolak' atau 'selesai' dari status pinjam aktif, kembalikan stok
            if (in_array($newStatus, ['ditolak', 'selesai'], true) && in_array($oldStatus, ['menunggu', 'disetujui'], true)) {
                $peminjaman->alat?->increment('stok', $peminjaman->jumlah);
            }

            $peminjaman->update(['status' => $newStatus]);
        });

        $peminjaman->load(['user', 'alat']);

        return response()->json([
            'success' => true,
            'message' => "Status peminjaman berhasil diperbarui menjadi {$newStatus}",
            'data' => new PeminjamanResource($peminjaman),
        ], 200);
    }

    /**
     * Menghapus catatan peminjaman (Khusus Admin/Laboran).
     */
    public function destroy(int $id): JsonResponse|Response
    {
        $peminjaman = Peminjaman::find($id);

        if (! $peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan',
            ], 404);
        }

        // Jika dihapus saat status masih aktif, pulihkan stok
        if (in_array($peminjaman->status, ['menunggu', 'disetujui'], true)) {
            $peminjaman->alat?->increment('stok', $peminjaman->jumlah);
        }

        $peminjaman->delete();

        return response()->noContent();
    }
}
