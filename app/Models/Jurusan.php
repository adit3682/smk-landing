<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
    'nama',
    'slug',
    'tema',
    'icon',
    'foto_utama',
    'deskripsi',
    'kurikulum',
    'keterampilan',
    'prospek_kerja',
];

    /**
     * Get all of the kegiatans for the Jurusan.
     */
    public function kegiatans(): HasMany
    {
        return $this->hasMany(JurusanKegiatan::class);
    }
    /** Kunci warna halaman: blue | violet | orange */
public function getTemaKeyAttribute(): string
{
    if (in_array($this->tema, ['blue', 'violet', 'orange'], true)) {
        return $this->tema;
    }

    // Kalau admin belum memilih, tebak dari slug/nama
    $s = strtolower($this->slug . ' ' . $this->nama);

    return match (true) {
        str_contains($s, 'desain'), str_contains($s, 'dkv'), str_contains($s, 'visual') => 'violet',
        str_contains($s, 'otomotif'), str_contains($s, 'kendaraan') => 'orange',
        default => 'blue',
    };
}

public function getKeterampilanListAttribute(): array
{
    return $this->splitBaris($this->keterampilan);
}

public function getProspekListAttribute(): array
{
    return $this->splitBaris($this->prospek_kerja);
}

protected function splitBaris(?string $teks): array
{
    $baris = preg_split('/\R/', (string) $teks);
    $baris = array_map(fn ($b) => trim(preg_replace('/^[\-\*\•]\s*/u', '', trim($b))), $baris);

    return array_values(array_filter($baris));
}
}