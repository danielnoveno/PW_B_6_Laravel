<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Menampilkan semua transaksi
    public function index()
    {
        $transaksis = Transaksi::all();
        return response()->json($transaksis);
    }

    // Menampilkan transaksi berdasarkan ID
    public function show($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    }

    // Membuat transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'buku_id' => 'required|exists:buku,id',
            'jenis_transaksi' => 'required|in:download,sewa',
        ]);

        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'jenis_transaksi' => $request->jenis_transaksi,
            'tgl_transaksi' => now(),
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil dibuat',
            'transaksi' => $transaksi,
        ], 201);
    }

    // Memperbarui transaksi berdasarkan ID
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $request->validate([
            'jenis_transaksi' => 'required|in:download,sewa',
        ]);

        $transaksi->update([
            'jenis_transaksi' => $request->jenis_transaksi,
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil diperbarui',
            'transaksi' => $transaksi,
        ]);
    }

    // Menghapus transaksi berdasarkan ID
    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus']);
    }
}
