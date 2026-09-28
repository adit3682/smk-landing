<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable =  ['nama', 'slug', 'icon', 'deskripsi', 'kurikulum', 'prospek_kerja'];
}
