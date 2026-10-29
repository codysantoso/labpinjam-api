<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Peminjaman
 */
class PeminjamanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_pinjam' => $this->kode_pinjam,
            'user_id' => $this->user_id,
            'alat_id' => $this->alat_id,
            'jumlah' => (int) $this->jumlah,
            'tanggal_pinjam' => $this->tanggal_pinjam?->format('Y-m-d'),
            'tanggal_kembali' => $this->tanggal_kembali?->format('Y-m-d'),
            'status' => $this->status,
            'user' => new UserResource($this->whenLoaded('user')),
            'alat' => new AlatResource($this->whenLoaded('alat')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
