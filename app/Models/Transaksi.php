<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'buku_id',
        'jenis_transaksi',
        'durasi',
        'metode_pembayaran',
        'total_harga',
        'tgl_transaksi',
    ];

    /**
     * Get the user associated with the transaksi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the buku associated with the transaksi.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
