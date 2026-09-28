<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    protected $fillable = ['peringkat', 'lembaga_penerbit', 'tahun_berlaku', 'file_sertifikat'];
}