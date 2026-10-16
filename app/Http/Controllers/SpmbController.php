<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\ProfilSekolah;

class SpmbController extends Controller
{
    public function index()
    {
        return view('spmb', [
            'profil' => ProfilSekolah::first(),
            'jurusans' => Jurusan::all(),
        ]);
    }
}