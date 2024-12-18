<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Menampilkan semua buku
    public function index()
    {
        $buku = Buku::all();
        return response()->json($buku);
    }

    public function indexAdmin()
    {
        $bukus = Buku::all();
        return response()->json($bukus);
    }

    // Menampilkan detail buku berdasarkan ID
    public function show($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($buku);
    }

    // Membuat buku baru
    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'penulis' => 'nullable|string|max:150',
                'penerbit' => 'nullable|string|max:150',
                'ISBN' => 'required|string|max:20|unique:buku,ISBN',
                'tgl_terbit' => 'nullable|date',
                'jenis_buku' => 'required|string|in:Scifi,Fantasy,Drama,Politik,Sejarah,Kamus,Jurnal ilmiah,Resep',
                'bahasa' => 'nullable|string|max:50',
                'halaman' => 'nullable|integer',
                'sinopsis' => 'nullable|string',
                'deskripsi' => 'nullable|string',
                'harga_download' => 'nullable|numeric|min:0',
                'harga_sewa' => 'nullable|numeric|min:0',
                'rating' => 'nullable|numeric|between:0,5',
                'review_count' => 'nullable|integer',
                'cover_imgpath' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048', // max 2MB
                'file_buku' => 'required|file|mimes:pdf,epub,doc,rtf|max:10240', // max 10MB
            ]);

            // Handle file uploads
            if ($request->hasFile('cover_imgpath') && $request->hasFile('file_buku')) {
                $coverPath = $request->file('cover_imgpath')->store('covers', 'public');
                $bookPath = $request->file('file_buku')->store('books', 'public');

                // Create book with file paths
                $buku = Buku::create([
                    'judul' => $request->judul,
                    'penulis' => $request->penulis,
                    'penerbit' => $request->penerbit,
                    'ISBN' => $request->ISBN,
                    'tgl_terbit' => $request->tgl_terbit,
                    'jenis_buku' => $request->jenis_buku,
                    'bahasa' => $request->bahasa,
                    'halaman' => $request->halaman,
                    'sinopsis' => $request->sinopsis,
                    'deskripsi' => $request->deskripsi,
                    'harga_download' => $request->harga_download,
                    'harga_sewa' => $request->harga_sewa,
                    'rating' => $request->rating ?? 0,
                    'review_count' => $request->review_count ?? 0,
                    'cover_imgpath' => $coverPath,
                    'file_buku' => $bookPath,
                ]);

                return response()->json([
                    'message' => 'Buku berhasil ditambahkan',
                    'data' => $buku
                ], 201);
            }

            return response()->json([
                'message' => 'File upload required'
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Error creating book: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error creating book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Memperbarui buku berdasarkan ID
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:150',
            'penerbit' => 'nullable|string|max:150',
            'ISBN' => 'required|string|max:20|unique:buku,ISBN',
            'tgl_terbit' => 'nullable|date',
            'jenis_buku' => 'required|string|in:Scifi,Fantasy,Drama,Politik,Sejarah,Kamus,Jurnal ilmiah,Resep',
            'bahasa' => 'nullable|string|max:50',
            'halaman' => 'nullable|integer',
            'sinopsis' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'harga_download' => 'nullable|numeric|min:0|max:999999999999',
            'harga_sewa' => 'nullable|numeric|min:0|max:999999999999',
            'rating' => 'nullable|numeric|between:0,5',
            'review_count' => 'nullable|integer',
            'cover_imgpath' => 'required|file|mimes:jpg,jpeg,png,gif',
            'file_buku' => 'required|file|mimes:pdf,epub,doc,rtf',
        ]);


        $buku->update([
            'cover_imgpath' => $request->cover_imgpath,
            'file_buku' => $request->file_buku,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'ISBN' => $request->ISBN,
            'tgl_terbit' => $request->tgl_terbit,
            'jenis_buku' => $request->jenis_buku,
            'bahasa' => $request->bahasa,
            'halaman' => $request->halaman,
            'sinopsis' => $request->sinopsis,
            'deskripsi' => $request->deskripsi,
            'harga_download' => $request->harga_download,
            'harga_sewa' => $request->harga_sewa,
            'rating' => $request->rating,
            'review_count' => $request->review_count,
        ]);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'buku' => $buku
        ]);
    }

    // Menghapus buku berdasarkan ID
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }

    public function getBookByISBN($isbn)
    {
        $book = Buku::where('ISBN', $isbn)->first();

        if ($book) {
            return response()->json($book);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }

    // Memperbarui buku berdasarkan ISBN
    public function updateByISBN(Request $request, $isbn)
    {
        $buku = Buku::where('ISBN', $isbn)->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:150',
            'penerbit' => 'nullable|string|max:150',
            'ISBN' => 'required|string|max:20|unique:buku,ISBN,' . $buku->id,  // Ignore ISBN of the current record
            'tgl_terbit' => 'nullable|date',
            'jenis_buku' => 'required|string|in:Scifi,Fantasy,Drama,Politik,Sejarah,Kamus,Jurnal ilmiah,Resep',
            'bahasa' => 'nullable|string|max:50',
            'halaman' => 'nullable|integer',
            'sinopsis' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'harga_download' => 'nullable|numeric|min:0|max:999999999999',
            'harga_sewa' => 'nullable|numeric|min:0|max:999999999999',
            'rating' => 'nullable|numeric|between:0,5',
            'review_count' => 'nullable|integer',
            'cover_imgpath' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'file_buku' => 'nullable|file|mimes:pdf,epub,doc,rtf',
        ]);

        // Handle file upload conditionally
        if ($request->hasFile('cover_imgpath')) {
            $coverImg = $request->file('cover_imgpath')->store('covers', 'public');
            $buku->cover_imgpath = $coverImg;
        }

        if ($request->hasFile('file_buku')) {
            $bookFile = $request->file('file_buku')->store('books', 'public');
            $buku->file_buku = $bookFile;
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'ISBN' => $buku->ISBN,  // Keep the original ISBN
            'tgl_terbit' => $request->tgl_terbit,
            'jenis_buku' => $request->jenis_buku,
            'bahasa' => $request->bahasa,
            'halaman' => $request->halaman,
            'sinopsis' => $request->sinopsis,
            'deskripsi' => $request->deskripsi,
            'harga_download' => $request->harga_download,
            'harga_sewa' => $request->harga_sewa,
            'rating' => $request->rating,
            'review_count' => $request->review_count,
        ]);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'buku' => $buku
        ]);
    }

    public function destroyByISBN($isbn)
    {
        $buku = Buku::where('ISBN', $isbn)->first();

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}
