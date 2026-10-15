<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function show(string $slug)
    {
        $jurusan = Jurusan::where('slug', $slug)->with('kegiatans')->firstOrFail();
        return view('jurusan.show', compact('jurusan'));
    }
}