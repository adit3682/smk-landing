<?php

namespace App\Http\Controllers;

use App\Models\{ProfilSekolah, DataSiswaTahunan, Staf, Akreditasi, StrukturOrganisasi};

class ProfilSekolahController extends Controller
{
    public function index()
    {
        return view('profil-sekolah', [
            'profilSekolah' => ProfilSekolah::first(),
            'dataSiswa' => DataSiswaTahunan::orderBy('tahun_ajaran')->get(),
            'stafs' => Staf::all(),
            'akreditasi' => Akreditasi::latest('tahun_berlaku')->first(),
            'struktur' => StrukturOrganisasi::orderBy('urutan')->get(),
        ]);
    }
}