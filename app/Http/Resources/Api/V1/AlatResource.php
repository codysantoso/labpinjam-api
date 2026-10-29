<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Alat
 */
class AlatResource extends JsonResource
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
            'kode_alat' => $this->kode_alat,
            'nama_alat' => $this->nama_alat,
            'stok' => (int) $this->stok,
            'kondisi' => $this->kondisi,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
