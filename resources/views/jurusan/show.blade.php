@extends('layouts.app')

@section('title', $jurusan->nama)

@section('content')
<div class="pt-32 pb-20 px-6 max-w-3xl mx-auto">

    <span class="text-sm font-semibold text-blue-600 uppercase">Kompetensi Keahlian</span>
    <h1 class="text-4xl font-extrabold text-blue-950 mt-2 mb-8">{{ $jurusan->nama }}</h1>

    <div class="prose prose-blue max-w-none text-slate-700 mb-10">
        <p>{{ $jurusan->deskripsi }}</p>
    </div>

    @if($jurusan->kurikulum)
        <div class="mb-10">
            <h2 class="text-xl font-bold text-blue-900 mb-3">Kurikulum</h2>
            <div class="prose prose-blue max-w-none text-slate-700">
                <p>{{ $jurusan->kurikulum }}</p>
            </div>
        </div>
    @endif

    @if($jurusan->prospek_kerja)
        <div class="mb-10">
            <h2 class="text-xl font-bold text-blue-900 mb-3">Prospek Kerja</h2>
            <div class="prose prose-blue max-w-none text-slate-700">
                <p>{{ $jurusan->prospek_kerja }}</p>
            </div>
        </div>
    @endif

    <a href="{{ route('home') }}#jurusan" class="text-blue-700 font-semibold hover:underline">&larr; Kembali ke Beranda</a>
</div>
@endsection