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
        'icon', 
        'deskripsi', 
        'kurikulum', 
        'prospek_kerja'
    ];

    /**
     * Get all of the kegiatans for the Jurusan.
     */
    public function kegiatans(): HasMany
    {
        return $this->hasMany(JurusanKegiatan::class);
    }
}