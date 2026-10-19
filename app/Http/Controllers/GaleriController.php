<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\ProfilSekolah;

class GaleriController extends Controller
{
    public function index()
    {
        return view('galeri', [
            'profilSekolah' => ProfilSekolah::first(),
            'galeris'       => Galeri::orderBy('urutan')->orderByDesc('id')->paginate(8),
        ]);
    }
}