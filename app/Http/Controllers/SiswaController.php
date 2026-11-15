<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        try {
            $siswas = Siswa::all();
            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil ditampilkan',
                'data'    => $siswas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data siswa',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|max:100',
            'kelas'   => 'required|max:20',
            'jurusan' => 'required|max:20',
        ]);

        try {
            $siswa = Siswa::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil ditambahkan',
                'data'    => $siswa
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa gagal ditambahkan',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa ditemukan',
                'data'    => $siswa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan',
                'error'   => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama'    => 'required|max:100',
            'kelas'   => 'required|max:20',
            'jurusan' => 'required|max:20',
        ]);

        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diupdate',
                'data'    => $siswa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa gagal diupdate',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa gagal dihapus',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}