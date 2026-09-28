<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    protected $table = 'profil_sekolah';
    protected $fillable = ['nama_sekolah', 'logo','foto_hero', 'npsn', 'alamat', 'kode_pos', 'nama_kepala_sekolah', 'visi', 'misi', 'profil_yayasan','instagram', 'facebook', 'linkedin'];
    protected $casts = ['misi' => 'array'];
}
