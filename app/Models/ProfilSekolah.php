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
        'gmaps_embed',
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