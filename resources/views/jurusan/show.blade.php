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

    @if($jurusan->keterampilan)
        <div class="mb-10">
            <h2 class="text-xl font-bold text-blue-900 mb-3">Keterampilan yang Dipelajari</h2>
            <ul class="space-y-2 text-slate-700">
                @foreach(explode("\n", trim($jurusan->keterampilan)) as $item)
                    @if(trim($item))
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 mt-1">✓</span>
                            <span>{{ trim($item) }}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    @if($jurusan->kegiatans->count())
        <div class="mb-10">
            <h2 class="text-xl font-bold text-blue-900 mb-3">Kegiatan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach($jurusan->kegiatans as $kegiatan)
                    <div class="rounded-xl border border-blue-100 overflow-hidden bg-white shadow-sm">
                        @if($kegiatan->foto)
                            <img src="{{ Storage::url($kegiatan->foto) }}" alt="{{ $kegiatan->judul }}" class="w-full h-40 object-cover">
                        @endif
                        <div class="p-4">
                            <span class="text-xs font-semibold text-blue-600 uppercase">{{ $kegiatan->kategori }}</span>
                            <h3 class="font-bold text-blue-950 mt-1">{{ $kegiatan->judul }}</h3>
                            @if($kegiatan->deskripsi)
                                <p class="text-sm text-slate-600 mt-1">{{ $kegiatan->deskripsi }}</p>
                            @endif
                            @if($kegiatan->tanggal)
                                <p class="text-xs text-slate-400 mt-2">{{ $kegiatan->tanggal->translatedFormat('d F Y') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
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