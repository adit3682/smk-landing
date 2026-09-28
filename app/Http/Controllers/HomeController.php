<?php

namespace App\Http\Controllers;

use App\Models\{Guru, Jurusan, Galeri, Artikel, ProfilSekolah, DataSiswaTahunan, Staf, Pengaturan};

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'profilSekolah' => ProfilSekolah::first(),
            'gurus' => Guru::orderBy('urutan')->get(),
            'jurusans' => Jurusan::all(),
            'galeris' => Galeri::orderBy('urutan')->get(),
            'artikels' => Artikel::where('status', 'publish')->latest('published_at')->take(3)->get(),
            'siswaAktif' => DataSiswaTahunan::latest('tahun_ajaran')->value('jumlah') ?? 0,
            'jumlahGuruStaf' => Guru::count() + Staf::count(),
            'jumlahJurusan' => Jurusan::count(),
            'alumniPersen' => Pengaturan::where('key', 'alumni_terserap_persen')->value('value') ?? 0,
            'linkPpdb' => Pengaturan::where('key', 'link_ppdb')->value('value') ?? '#',
        ]);
    }
}