<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'slug', 'kategori', 'thumbnail', 'excerpt', 'konten', 'status', 'pinned', 'published_at'];

    protected $casts = [
        'pinned' => 'boolean',
        'published_at' => 'datetime',
    ];
}