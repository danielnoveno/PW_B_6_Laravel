<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Menampilkan informasi admin yang sedang terautentikasi
    public function show($id)
    {
        $admin = Auth::user(); // Assuming admin is authenticated using Sanctum or other methods
        if (!$admin || $admin->id !== (int) $id) {
            return response()->json(['message' => 'Unauthorized atau admin tidak ditemukan'], 403);
        }
        return response()->json($admin);
    }

    // Menampilkan profil admin yang sedang terautentikasi
    public function index()
    {
        $admin = Auth::user();
        if (!$admin) {
            return response()->json(['message' => 'Admin tidak terautentikasi'], 401);
        }
        return response()->json([$admin]);
    }

    // Memperbarui informasi admin yang sedang terautentikasi
    public function update(Request $request)
    {
        $admin = Auth::user();
        if (!$admin) {
            return response()->json(['message' => 'Admin tidak terautentikasi'], 401);
        }

        // Validasi input untuk update informasi admin
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:admin,email,' . $admin->id,
            'no_telp' => 'nullable|string|max:15',
            'sandi' => 'nullable|string|min:8', // Password bersifat opsional
        ]);

        // Update data yang dapat diedit
        $admin->nama = $request->nama;
        $admin->email = $request->email;
        $admin->no_telp = $request->no_telp;

        // Jika sandi ada, hash dan update
        if ($request->sandi) {
            $admin->sandi = Hash::make($request->sandi);
        }

        $admin->save();

        return response()->json([
            'message' => 'Admin berhasil diperbarui',
            'admin' => $admin,
        ]);
    }

    // Menghapus akun admin yang sedang terautentikasi
    public function destroy(Request $request)
    {
        $admin = Auth::user();
        if (!$admin) {
            return response()->json(['message' => 'Tidak terautentikasi'], 401);
        }

        $admin->delete();

        return response()->json(['message' => 'Admin berhasil dihapus']);
    }

    // Mendaftarkan admin baru
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:admin',
            'sandi' => 'required|string|min:8',
        ]);

        $admin = Admin::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'sandi' => Hash::make($request->sandi),
        ]);

        return response()->json([
            'admin' => $admin,
            'message' => 'Admin berhasil terdaftar',
        ], 201);
    }

    // Melakukan login admin dan memberikan token akses
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'sandi' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->sandi, $admin->sandi)) {
            return response()->json(['message' => 'Kredensial tidak valid'], 401);
        }

        $token = $admin->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'admin' => $admin,
            'token' => $token,
        ]);
    }

    // Melakukan logout admin yang terautentikasi
    public function logout(Request $request)
    {
        $admin = Auth::user();

        if ($admin) {
            // Menghapus semua token akses milik admin
            $admin->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json(['message' => 'Logout berhasil']);
        }

        return response()->json(['message' => 'Tidak terlogin'], 401);
    }
}
