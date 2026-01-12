<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Get all categories
     * GET /api/v1/admin/kategori
     */
    public function index(Request $request): JsonResponse
    {
        $query = Kategori::withCount('produk')->orderBy('nama_kategori');

        // Search
        if ($request->filled('q')) {
            $query->where('nama_kategori', 'like', '%' . $request->input('q') . '%');
        }

        $kategori = $query->get()->map(function ($item) {
            return $this->transformKategori($item);
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar kategori berhasil diambil.',
            'data' => $kategori,
        ]);
    }

    /**
     * Create category
     * POST /api/v1/admin/kategori
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:50|unique:kategori,nama_kategori',
            'deskripsi' => 'nullable|string|max:500',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'slug_kategori' => Str::slug($request->nama_kategori),
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'data' => $this->transformKategori($kategori),
        ], 201);
    }

    /**
     * Get category detail
     * GET /api/v1/admin/kategori/{id}
     */
    public function show(int $id): JsonResponse
    {
        $kategori = Kategori::withCount('produk')->find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kategori berhasil diambil.',
            'data' => $this->transformKategori($kategori),
        ]);
    }

    /**
     * Update category
     * PUT /api/v1/admin/kategori/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'sometimes|required|string|max:50|unique:kategori,nama_kategori,' . $id . ',id_kategori',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->has('nama_kategori')) {
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->slug_kategori = Str::slug($request->nama_kategori);
        }
        if ($request->has('deskripsi')) {
            $kategori->deskripsi = $request->deskripsi;
        }
        $kategori->save();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
            'data' => $this->transformKategori($kategori),
        ]);
    }

    /**
     * Delete category
     * DELETE /api/v1/admin/kategori/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $kategori = Kategori::withCount('produk')->find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        if ($kategori->produk_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus kategori yang memiliki produk.',
            ], 400);
        }

        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.',
        ]);
    }

    private function transformKategori(Kategori $kategori): array
    {
        return [
            'id' => $kategori->id_kategori,
            'nama' => $kategori->nama_kategori,
            'slug' => $kategori->slug_kategori,
            'deskripsi' => $kategori->deskripsi,
            'jumlah_produk' => $kategori->produk_count ?? 0,
            'tgl_dibuat' => $kategori->tgl_dibuat?->toIso8601String(),
        ];
    }
}
