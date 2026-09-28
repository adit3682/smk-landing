<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
     protected $fillable = ['judul', 'periode', 'tahun', 'tahap', 'sumber_dana', 'gambar', 'file_pdf', 'keterangan', 'urutan'];
}
