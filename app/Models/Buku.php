<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cover_imgpath',
        'file_buku',
        'judul',
        'penulis',
        'penerbit',
        'ISBN',
        'tgl_terbit',
        'jenis_buku',
        'bahasa',
        'halaman',
        'sinopsis',
        'deskripsi',
        'harga_download',
        'harga_sewa',
        'rating',
        'review_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Add any attributes that should be hidden from serialization
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'tgl_terbit' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'buku'; // Specify the table name if it doesn't match the plural form of the model
}
