<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Alat\StoreAlatRequest;
use App\Http\Requests\Api\V1\Alat\UpdateAlatRequest;
use App\Http\Resources\Api\V1\AlatResource;
use App\Models\Alat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AlatController extends Controller
{
    /**
     * Menampilkan daftar semua alat laboratorium.
     */
    public function index(): AnonymousResourceCollection
    {
        $alats = Alat::latest('id')->get();

        return AlatResource::collection($alats);
    }

    /**
     * Menyimpan inventaris alat laboratorium baru (Admin).
     */
    public function store(StoreAlatRequest $request): JsonResponse
    {
        $alat = Alat::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Alat berhasil ditambahkan',
            'data' => new AlatResource($alat),
        ], 201);
    }

    /**
     * Menampilkan detail satu alat laboratorium.
     */
    public function show(int $id): JsonResponse
    {
        $alat = Alat::find($id);

        if (! $alat) {
            return response()->json([
                'success' => false,
                'message' => 'Alat tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new AlatResource($alat),
        ], 200);
    }

    /**
     * Memperbarui informasi alat laboratorium (Admin).
     */
    public function update(UpdateAlatRequest $request, int $id): JsonResponse
    {
        $alat = Alat::find($id);

        if (! $alat) {
            return response()->json([
                'success' => false,
                'message' => 'Alat tidak ditemukan',
            ], 404);
        }

        $alat->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Alat berhasil diperbarui',
            'data' => new AlatResource($alat),
        ], 200);
    }

    /**
     * Menghapus alat laboratorium (Admin).
     */
    public function destroy(int $id): JsonResponse|Response
    {
        $alat = Alat::find($id);

        if (! $alat) {
            return response()->json([
                'success' => false,
                'message' => 'Alat tidak ditemukan',
            ], 404);
        }

        $alat->delete();

        return response()->noContent();
    }
}
