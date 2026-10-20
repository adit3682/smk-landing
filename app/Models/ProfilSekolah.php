<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    protected $table = 'profil_sekolah';

    protected $fillable = [
        'nama_sekolah',
        'logo',
        'foto_hero',
        'npsn',
        'alamat',
        'kode_pos',
        'nama_kepala_sekolah',
        'visi',
        'misi',
        'profil_yayasan',
        'instagram',
        'facebook',
        'linkedin',
        'tiktok',
        'spmb_posters',
        'spmb_link',
        'spmb_whatsapp',
        'spmb_tahun_ajaran',
        'spmb_biaya',
        'spmb_promo',
        'persyaratan_pendaftaran',
        'ekstrakurikuler',
        'gmaps_embed',
        'telepon',
        'email',
        'foto_kepala_sekolah',
        'sambutan_kepala_sekolah',
        'foto_mengapa_memilih',
        'mengapa_memilih_teks',
        'foto_background_hero',
        'struktur_yayasan',
        'spmb_mitra',
        'spmb_testimoni',
        'struktur_gambar',
    ];
    protected $casts = [
    'misi' => 'array',
    'spmb_posters' => 'array',
];

    public function getGmapsEmbedUrlAttribute(): ?string
    {
        $value = trim((string) $this->gmaps_embed);

        if ($value === '') {
            return null;
        }

        // Kalau admin menempel kode <iframe ...>, ambil isi src-nya saja
        if (preg_match('/src=["\']([^"\']+)["\']/i', $value, $m)) {
            $value = html_entity_decode($m[1]);
        }

        return str_starts_with(
            $value,
            'https://www.google.com/maps/embed'
        ) ? $value : null;
    }
}