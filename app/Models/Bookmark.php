<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmark';

    protected $fillable = [
        'user_id',
        'buku_id',
    ];

    // Relationship with User (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Timestamps are automatically managed by Eloquent
    public $timestamps = true;
}
