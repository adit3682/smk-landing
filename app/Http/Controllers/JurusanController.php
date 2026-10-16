<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function show(string $slug)
{
    $jurusan = Jurusan::where('slug', $slug)
        ->with(['kegiatans' => fn ($q) => $q->latest('tanggal')])
        ->firstOrFail();

    $lainnya = Jurusan::where('id', '!=', $jurusan->id)->orderBy('nama')->get();

    return view('jurusan.show', compact('jurusan', 'lainnya'));
}
}