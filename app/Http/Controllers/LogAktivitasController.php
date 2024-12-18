<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    // Menampilkan daftar aktivitas
    public function index()
    {
        $logAktivitas = LogAktivitas::all();
        return response()->json($logAktivitas);
    }

    // Menampilkan detail aktivitas berdasarkan ID
    public function show($id)
    {
        $logAktivitas = LogAktivitas::find($id);
        if (!$logAktivitas) {
            return response()->json(['message' => 'Aktivitas tidak ditemukan'], 404);
        }
        return response()->json($logAktivitas);
    }

    // Menyimpan aktivitas baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'aktivitas' => 'required|in:login,logout,baca,download,sewa,bookmark',
            'detail_aktivitas' => 'required|string',
        ]);

        $logAktivitas = LogAktivitas::create([
            'user_id' => $request->user_id,
            'aktivitas' => $request->aktivitas,
            'detail_aktivitas' => $request->detail_aktivitas,
        ]);

        return response()->json([
            'message' => 'Aktivitas berhasil disimpan',
            'log_aktivitas' => $logAktivitas,
        ], 201);
    }

    // Memperbarui aktivitas berdasarkan ID
    public function update(Request $request, $id)
    {
        $logAktivitas = LogAktivitas::find($id);
        if (!$logAktivitas) {
            return response()->json(['message' => 'Aktivitas tidak ditemukan'], 404);
        }

        $request->validate([
            'aktivitas' => 'nullable|in:login,logout,baca,download,sewa,bookmark',
            'detail_aktivitas' => 'nullable|string',
        ]);

        $logAktivitas->update($request->only(['aktivitas', 'detail_aktivitas']));
        return response()->json([
            'message' => 'Aktivitas berhasil diperbarui',
            'log_aktivitas' => $logAktivitas,
        ]);
    }

    // Menghapus aktivitas berdasarkan ID
    public function destroy($id)
    {
        $logAktivitas = LogAktivitas::find($id);
        if (!$logAktivitas) {
            return response()->json(['message' => 'Aktivitas tidak ditemukan'], 404);
        }

        $logAktivitas->delete();
        return response()->json(['message' => 'Aktivitas berhasil dihapus']);
    }
}
