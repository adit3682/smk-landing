<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\ProfilSekolah;
use App\Models\Sarpras;

class SpmbController extends Controller
{
    public function index()
    {
        return view('spmb', [
            'profil' => ProfilSekolah::first(),
            'jurusans' => Jurusan::all(),
            'sarpras' => Sarpras::take(6)->get(),
        ]);
    }
}