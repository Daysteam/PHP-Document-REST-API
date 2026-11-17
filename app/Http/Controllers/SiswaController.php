<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Throwable;

class SiswaController extends Controller
{
    /**
     * Menampilkan seluruh data siswa.
     */
    public function index()
    {
        try {
            $siswas = Siswa::all();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil ditampilkan',
                'data' => $siswas
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data siswa'
            ], 500);
        }
    }

    /**
     * Menambahkan data siswa.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|max:20',
            'kelas'   => 'required|max:10',
            'jurusan' => 'required|max:10',
        ]);

        try {
            $siswa = Siswa::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil ditambahkan',
                'data' => $siswa
            ], 201);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Data siswa gagal ditambahkan'
            ], 500);
        }
    }

    /**
     * Menampilkan detail siswa.
     */
    public function show($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa ditemukan',
                'data' => $siswa
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * Memperbarui data siswa.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama'    => 'sometimes|required|max:20',
            'kelas'   => 'sometimes|required|max:10',
            'jurusan' => 'sometimes|required|max:10',
        ]);

        try {
            $siswa = Siswa::findOrFail($id);

            $siswa->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diupdate',
                'data' => $siswa->fresh()
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Data siswa gagal diupdate'
            ], 500);
        }
    }

    /**
     * Menghapus data siswa.
     */
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            $siswa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil dihapus'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Data siswa gagal dihapus'
            ], 500);
        }
    }
}