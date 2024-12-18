<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'email',
        'no_telp',
        'tgl_lahir',
        'jenis_kelamin',
        'sandi',
        'bookmark',
        'unduhan',
        'buku_terakhir_dibaca',
        'rekomendasi',
        'kategori',
        'digilibrary',
        'profilePic'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'sandi',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'tgl_lahir' => 'date',
        'bookmark' => 'array', // Cast JSON to array
        'unduhan' => 'array', // Cast JSON to array
        'rekomendasi' => 'array', // Cast JSON to array
        'kategori' => 'array', // Cast JSON to array
        'digilibrary' => 'array', // Cast JSON to array
    ];

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'user'; // Specify the table name if it doesn't match the plural form of the model
}
