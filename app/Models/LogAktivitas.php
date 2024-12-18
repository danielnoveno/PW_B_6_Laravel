<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'aktivitas',
        'detail_aktivitas',
        'timestamp',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'timestamp' => 'datetime',
    ];

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_aktivitas';
}
