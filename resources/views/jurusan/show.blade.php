@extends('layouts.app')

@section('title', $jurusan->nama)

@section('content')
<div class="pt-32 pb-20 px-6 max-w-5xl mx-auto">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-14">

        {{-- Teks --}}
        <div>
            <span class="text-sm font-semibold text-blue-600 uppercase">Kompetensi Keahlian</span>
            <h1 class="text-4xl font-extrabold text-blue-950 mt-2 mb-6">{{ $jurusan->nama }}</h1>
            <div class="prose prose-blue max-w-none text-slate-700">
                <p>{{ $jurusan->deskripsi }}</p>
            </div>
        </div>

        {{-- Foto + dekorasi segitiga --}}
        @if($jurusan->foto_utama)
            <div class="relative mx-auto lg:mx-0 max-w-sm">
                <svg class="absolute -top-8 -left-6 w-16 h-16 text-yellow-400 z-0" viewBox="0 0 100 100" fill="none">
                    <polygon points="50,10 90,90 10,90" stroke="currentColor" stroke-width="7"/>
                </svg>
                <svg class="absolute top-1/3 -right-8 w-10 h-10 text-yellow-400 rotate-12 z-0" viewBox="0 0 100 100" fill="none">
                    <polygon points="50,10 90,90 10,90" stroke="currentColor" stroke-width="8"/>
                </svg>
                <svg class="absolute -bottom-6 -right-4 w-20 h-20 text-yellow-400 -rotate-6 z-0" viewBox="0 0 100 100" fill="none">
                    <polygon points="50,10 90,90 10,90" stroke="currentColor" stroke-width="6"/>
                </svg>

                <img src="{{ Storage::url($jurusan->foto_utama) }}"
                     alt="{{ $jurusan->nama }}"
                     class="relative z-10 w-full aspect-[4/5] object-cover shadow-xl"
                     style="border-radius: 28px; clip-path: polygon(40px 0, 100% 0, 100% 100%, 0 100%, 0 40px);">
            </div>
        @endif

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