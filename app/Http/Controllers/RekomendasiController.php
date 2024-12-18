<?php

namespace App\Http\Controllers;

use App\Models\Rekomendasi;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    // Menampilkan semua rekomendasi
    public function index()
    {
        $rekomendasi = Rekomendasi::all();
        return response()->json($rekomendasi);
    }

    // Menampilkan rekomendasi berdasarkan ID
    public function show($id)
    {
        $rekomendasi = Rekomendasi::find($id);
        if (!$rekomendasi) {
            return response()->json(['message' => 'Rekomendasi tidak ditemukan'], 404);
        }
        return response()->json($rekomendasi);
    }

    // Menyimpan rekomendasi baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'rekomendasi_buku' => 'required|array',
        ]);

        $rekomendasi = Rekomendasi::create([
            'user_id' => $request->user_id,
            'rekomendasi_buku' => $request->rekomendasi_buku,
        ]);

        return response()->json($rekomendasi, 201);
    }

    // Memperbarui rekomendasi
    public function update(Request $request, $id)
    {
        $rekomendasi = Rekomendasi::find($id);
        if (!$rekomendasi) {
            return response()->json(['message' => 'Rekomendasi tidak ditemukan'], 404);
        }

        $request->validate([
            'rekomendasi_buku' => 'required|array',
        ]);

        $rekomendasi->update([
            'rekomendasi_buku' => $request->rekomendasi_buku,
        ]);

        return response()->json($rekomendasi);
    }

    // Menghapus rekomendasi
    public function destroy($id)
    {
        $rekomendasi = Rekomendasi::find($id);
        if (!$rekomendasi) {
            return response()->json(['message' => 'Rekomendasi tidak ditemukan'], 404);
        }

        $rekomendasi->delete();

        return response()->json(['message' => 'Rekomendasi berhasil dihapus']);
    }
}
