<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil ditampilkan',
            'data'    => $siswas
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|max:20',
            'kelas'   => 'required|max:10',
            'jurusan' => 'required|max:10',
        ]);

        $siswa = Siswa::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil ditambahkan',
            'data'    => $siswa
        ], 201);
    }

    public function show($id)
    {
        // Jika data tidak ditemukan, findOrFail otomatis melempar ModelNotFoundException.
        // Exception ini akan ditangkap secara otomatis oleh bootstrap/app.php milikmu.
        $siswa = Siswa::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa ditemukan',
            'data'    => $siswa
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama'    => 'sometimes|max:20',
            'kelas'   => 'sometimes|max:10',
            'jurusan' => 'sometimes|max:10',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diupdate',
            'data'    => $siswa
        ], 200);
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil dihapus'
        ], 200);
    }
}