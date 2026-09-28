<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;

class TransparansiController extends Controller
{
    public function index()
    {
        $laporans = LaporanKeuangan::orderByDesc('tahun')
            ->orderBy('urutan')
            ->get();

        return view('transparansi', compact('laporans'));
    }
}