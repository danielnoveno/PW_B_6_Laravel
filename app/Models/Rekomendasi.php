<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rekomendasi_buku',
    ];

    protected $casts = [
        'rekomendasi_buku' => 'array',
    ];

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'rekomendasi'; 
}
