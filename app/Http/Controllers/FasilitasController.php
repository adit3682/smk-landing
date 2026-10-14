<?php

namespace App\Http\Controllers;

use App\Models\{ProfilSekolah, Sarpras};

class FasilitasController extends Controller
{
    public function index()
    {
        return view('fasilitas', [
            'profilSekolah' => ProfilSekolah::first(),
            'sarpras' => Sarpras::all(),
        ]);
    }
}