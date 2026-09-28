<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpmbController extends Controller
{
    public function index()
    {
        return view('spmb', [
            'profil' => \App\Models\ProfilSekolah::first()
        ]);
    }
}