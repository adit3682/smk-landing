<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;

class KontakController extends Controller
{
    public function index()
    {
        return view('kontak', [
            'profilSekolah' => ProfilSekolah::first(),
        ]);
    }
}