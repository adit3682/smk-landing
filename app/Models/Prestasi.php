<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = ['judul', 'deskripsi', 'tanggal', 'foto'];
}
