<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        if (!$user || $user->id !== (int) $id) {
            return response()->json(['message' => 'Unauthorized atau pengguna tidak ditemukan'], 403);
        }

        if ($user->profilePic) {
            $user->profilePic = url('storage/' . $user->profilePic);
        }

        return response()->json($user);
    }

    // Menampilkan profil pengguna yang sedang terautentikasi
    public function index()
    {
        try {
            // Mengambil semua data user dari tabel 'users'
            $users = User::all();

            return response()->json([
                'message' => 'Data pengguna berhasil diambil.',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data pengguna.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Memperbarui informasi pengguna yang sedang terautentikasi
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak terautentikasi'], 401);
        }

        try {
            $validatedData = $request->validate([
                'nama_depan' => 'required|string|max:100',
                'nama_belakang' => 'nullable|string|max:100',
                'email' => 'required|string|email|max:255|unique:user,email,' . $user->id,
                'no_telp' => 'nullable|string|max:15',
                'tgl_lahir' => 'nullable|date',
                'jenis_kelamin' => 'nullable|in:L,P',
                'profilePic' => 'nullable|image|max:2048', // Validasi untuk foto profil
            ]);

            // Update other fields
            $user->nama_depan = $validatedData['nama_depan'];
            $user->nama_belakang = $validatedData['nama_belakang'] ?? null;
            $user->email = $validatedData['email'];
            $user->no_telp = $validatedData['no_telp'] ?? null;
            $user->tgl_lahir = $validatedData['tgl_lahir'] ?? null;
            $user->jenis_kelamin = $validatedData['jenis_kelamin'] ?? null;

            // Handle profile picture upload
            if ($request->hasFile('profilePic')) {
                // Delete old profile picture if exists
                if ($user->profilePic && Storage::exists('public/' . $user->profilePic)) {
                    Storage::delete('public/' . $user->profilePic);
                }

                // Store new profile picture
                $profilePicPath = $request->file('profilePic')->store('profile_pics', 'public');
                $user->profilePic = str_replace('public/', '', $profilePicPath);
            }

            $user->save();

            return response()->json([
                'message' => 'Pengguna berhasil diperbarui',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui pengguna',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateAsAdmin(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $id,
        ]);

        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui data user (hanya field yang diperlukan)
        $user->update($request->only(['nama_depan', 'nama_belakang', 'email']));

        // Kembalikan response berhasil
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    // Menghapus akun pengguna yang sedang terautentikasi
    public function destroy(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Tidak terautentikasi'], 401);
        }

        $user->delete();

        return response()->json(['message' => 'Pengguna berhasil dihapus']);
    }

    // Mendaftarkan pengguna baru
    public function register(Request $request)
    {
        try {
            // Validasi - sesuaikan nama field dengan yang ada di database
            $validated = $request->validate([
                'nama_depan' => 'required|string|max:255',
                'nama_belakang' => 'required|string|max:255',
                'email' => 'required|email|unique:user,email',
                'no_telp' => 'required|numeric',
                'tgl_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:L,P',
                'sandi' => 'required|min:6',
            ]);

            // Simpan data pengguna setelah validasi
            User::create([
                'nama_depan' => $validated['nama_depan'],
                'nama_belakang' => $validated['nama_belakang'],
                'email' => $validated['email'],
                'no_telp' => $validated['no_telp'],
                'tgl_lahir' => $validated['tgl_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'sandi' => Hash::make($validated['sandi']),
            ]);

            return response()->json(['message' => 'Registrasi berhasil'], 201);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan di server'], 500);
        }
    }

    // Melakukan login pengguna dan memberikan token akses
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'sandi' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->sandi, $user->sandi)) {
            return response()->json(['message' => 'Kredensial tidak valid'], 401);
        }

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Melakukan logout pengguna yang terautentikasi
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Menghapus semua token akses milik pengguna
            $user->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json(['message' => 'Logout berhasil']);
        }

        return response()->json(['message' => 'Tidak terlogin'], 401);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:6',
                'different:current_password',
                'confirmed' // This matches new_password_confirmation
            ]
        ]);

        $user = Auth::user();

        // Debugging: Log the incoming current password
        \Log::info('Attempt to change password', [
            'user_id' => $user->id,
            'current_password_check' => Hash::check($request->input('current_password'), $user->sandi)
        ]);

        if (!Hash::check($request->input('current_password'), $user->sandi)) {
            return response()->json([
                'message' => 'Password lama yang Anda masukkan salah.'
            ], 400);
        }

        try {
            $user->sandi = Hash::make($request->input('new_password'));
            $user->save();

            return response()->json([
                'message' => 'Password berhasil diubah.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengubah password. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function countUsers()
    {
        $totalUsers = User::count();
        return response()->json(['total_users' => $totalUsers]);
    }
}
