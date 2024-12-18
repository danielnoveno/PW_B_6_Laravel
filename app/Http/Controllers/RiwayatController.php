<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    // Menampilkan semua riwayat buku
    public function index()
    {
        $riwayat = Riwayat::with('user')->get();
        return response()->json($riwayat);
    }

    // Menampilkan riwayat berdasarkan ID
    public function show($id)
    {
        $riwayat = Riwayat::with('user')->find($id);

        if (!$riwayat) {
            return response()->json(['message' => 'Riwayat tidak ditemukan'], 404);
        }

        return response()->json($riwayat);
    }

    // Menyimpan data riwayat baru
    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'tanggal_beli' => 'required|date',
            'harga' => 'required|integer',
            'status' => 'required|string|max:255',
            'id_user' => 'required|integer|exists:user,id'
        ]);

        $riwayat = Riwayat::create($request->all());

        return response()->json([
            'message' => 'Riwayat berhasil ditambahkan',
            'data' => $riwayat
        ], 201);
    }

    // Memperbarui data riwayat
    public function update(Request $request, $id)
    {
        $riwayat = Riwayat::find($id);

        if (!$riwayat) {
            return response()->json(['message' => 'Riwayat tidak ditemukan'], 404);
        }

        $request->validate([
            'judul_buku' => 'sometimes|string|max:255',
            'tanggal_beli' => 'sometimes|date',
            'harga' => 'sometimes|integer',
            'status' => 'sometimes|string|max:255',
            'id_user' => 'sometimes|integer|exists:user,id'
        ]);

        $riwayat->update($request->all());

        return response()->json([
            'message' => 'Riwayat berhasil diperbarui',
            'data' => $riwayat
        ]);
    }

    // Menghapus data riwayat
    public function destroy($id)
    {
        $riwayat = Riwayat::find($id);

        if (!$riwayat) {
            return response()->json(['message' => 'Riwayat tidak ditemukan'], 404);
        }

        $riwayat->delete();

        return response()->json(['message' => 'Riwayat berhasil dihapus']);
    }
}
