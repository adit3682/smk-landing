<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
{
    $artikels = Artikel::where('status', 'publish')
        ->when($request->kategori && $request->kategori !== 'semua', fn($q) =>
            $q->where('kategori', $request->kategori))
        ->when($request->search, fn($q) =>
            $q->where('judul', 'like', '%' . $request->search . '%'))
        ->latest('published_at')
        ->paginate(9)
        ->withQueryString();

    return view('artikel.index', compact('artikels'));
}

    public function show(string $slug)
    {
        $artikel = Artikel::where('slug', $slug)->where('status', 'publish')->firstOrFail();
        $terkait = Artikel::where('status', 'publish')->where('id', '!=', $artikel->id)->latest('published_at')->take(3)->get();
        return view('artikel.show', compact('artikel', 'terkait'));
    }
}