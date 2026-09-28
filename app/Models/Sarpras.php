<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sarpras extends Model
{
    protected $table = 'sarpras';
    protected $fillable = ['nama', 'deskripsi', 'foto', 'kondisi'];
}
