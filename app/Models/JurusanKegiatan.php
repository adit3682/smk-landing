<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurusanKegiatan extends Model
{
    protected $fillable = [
        'jurusan_id',
        'kategori',
        'judul',
        'deskripsi',
        'foto',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}