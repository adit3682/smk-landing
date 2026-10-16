@extends('layouts.app')

@section('title', 'SPMB - ' . ($profil->nama_sekolah ?? 'Penerimaan Murid Baru'))

@section('content')

{{-- HERO --}}
<section class="relative pt-32 pb-16 px-6 bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 text-white overflow-hidden">
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <span class="inline-block bg-white/10 border border-white/25 text-blue-100 text-xs font-semibold px-4 py-1.5 rounded-full mb-5">
            SISTEM PENERIMAAN MURID BARU — TAHUN AJARAN {{ $profil->spmb_tahun_ajaran ?? '-' }}
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">SPMB {{ $profil->nama_sekolah ?? '' }}</h1>
        <p class="text-blue-200 max-w-xl mx-auto mb-8">
            Daftarkan dirimu sekarang dan jadi bagian dari generasi talenta digital masa depan.
        </p>

        <div class="flex flex-wrap justify-center gap-4 mb-6">
            @if($profil->spmb_biaya)
                <div class="bg-white/10 border border-white/20 rounded-xl px-5 py-3">
                    <div class="text-xs text-blue-200 uppercase">Biaya Pendaftaran</div>
                    <div class="text-lg font-bold text-white">{{ $profil->spmb_biaya }}</div>
                </div>
            @endif
        </div>

        @if($profil->spmb_promo)
            <p class="text-yellow-300 font-semibold mb-8">🎁 {{ $profil->spmb_promo }}</p>
        @endif

        <div class="flex flex-wrap justify-center gap-4">
            @if($profil->spmb_link)
                <a href="{{ $profil->spmb_link }}" target="_blank"
                   class="bg-white text-blue-900 font-semibold px-8 py-3 rounded-full hover:bg-blue-100 transition">
                    Daftar Sekarang
                </a>
            @endif
            @if($profil->spmb_whatsapp)
                <a href="https://wa.me/62{{ ltrim($profil->spmb_whatsapp, '0') }}" target="_blank"
                   class="bg-green-500 text-white font-semibold px-8 py-3 rounded-full hover:bg-green-600 transition flex items-center gap-2">
                    <span>Hubungi via WhatsApp</span>
                </a>
            @endif
        </div>
    </div>
</section>

{{-- POSTER --}}
@if($profil->spmb_posters && count($profil->spmb_posters))
    <section class="py-16 px-6 max-w-4xl mx-auto">
        <div class="grid grid-cols-1 {{ count($profil->spmb_posters) > 1 ? 'md:grid-cols-2' : '' }} gap-6">
            @foreach($profil->spmb_posters as $poster)
                <img src="{{ Storage::url($poster) }}" alt="Poster SPMB" class="w-full rounded-2xl shadow-lg">
            @endforeach
        </div>
    </section>
@endif

{{-- PROGRAM KEAHLIAN --}}
@if($jurusans->count())
    <section class="py-16 px-6 bg-blue-50">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-2xl font-bold text-blue-950 text-center mb-10">Program Keahlian</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($jurusans as $jurusan)
                    <a href="{{ route('jurusan.show', $jurusan->slug) }}"
                       class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition block">
                        @if($jurusan->icon)
                            <img src="{{ Storage::url($jurusan->icon) }}" alt="{{ $jurusan->nama }}" class="w-16 h-16 mx-auto mb-4 object-contain">
                        @endif
                        <h3 class="font-bold text-blue-950">{{ $jurusan->nama }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- PERSYARATAN & EKSTRAKURIKULER --}}
@if($profil->persyaratan_pendaftaran || $profil->ekstrakurikuler)
    <section class="py-16 px-6 max-w-5xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            @if($profil->persyaratan_pendaftaran)
                <div>
                    <h2 class="text-xl font-bold text-blue-900 mb-4">Persyaratan Pendaftaran</h2>
                    <ul class="space-y-2">
                        @foreach(explode("\n", trim($profil->persyaratan_pendaftaran)) as $item)
                            @if(trim($item))
                                <li class="flex items-start gap-2 text-slate-700">
                                    <span class="text-blue-600 mt-1">✓</span>
                                    <span>{{ trim($item) }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($profil->ekstrakurikuler)
                <div>
                    <h2 class="text-xl font-bold text-blue-900 mb-4">Ekstrakurikuler</h2>
                    <ul class="grid grid-cols-2 gap-y-2">
                        @foreach(explode("\n", trim($profil->ekstrakurikuler)) as $item)
                            @if(trim($item))
                                <li class="flex items-start gap-2 text-slate-700">
                                    <span class="text-blue-600 mt-1">•</span>
                                    <span>{{ trim($item) }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </section>
@endif

{{-- ALUR PENDAFTARAN --}}
<section class="py-16 px-6 bg-blue-50">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-blue-950 text-center mb-10">Cara Pendaftaran</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                <div class="w-12 h-12 rounded-full bg-blue-900 text-white font-bold flex items-center justify-center mx-auto mb-4">1</div>
                <h3 class="font-bold text-blue-950 mb-2">Siapkan Dokumen</h3>
                <p class="text-sm text-slate-600">Lengkapi dokumen sesuai persyaratan pendaftaran di atas.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                <div class="w-12 h-12 rounded-full bg-blue-900 text-white font-bold flex items-center justify-center mx-auto mb-4">2</div>
                <h3 class="font-bold text-blue-950 mb-2">Isi Formulir Pendaftaran</h3>
                <p class="text-sm text-slate-600">Klik "Daftar Sekarang" atau hubungi panitia via WhatsApp.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                <div class="w-12 h-12 rounded-full bg-blue-900 text-white font-bold flex items-center justify-center mx-auto mb-4">3</div>
                <h3 class="font-bold text-blue-950 mb-2">Konfirmasi & Daftar Ulang</h3>
                <p class="text-sm text-slate-600">Panitia akan menghubungi untuk proses selanjutnya.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 px-6">
    <div class="max-w-4xl mx-auto bg-gradient-to-br from-blue-950 to-blue-800 rounded-3xl p-10 text-center text-white">
        <h2 class="text-2xl font-bold mb-3">Punya Pertanyaan?</h2>
        <p class="text-blue-200 mb-6">Tim kami siap membantu proses pendaftaranmu.</p>
        <div class="flex flex-wrap justify-center gap-4">
            @if($profil->spmb_whatsapp)
                <a href="https://wa.me/62{{ ltrim($profil->spmb_whatsapp, '0') }}" target="_blank"
                   class="bg-green-500 text-white font-semibold px-8 py-3 rounded-full hover:bg-green-600 transition">
                    Chat WhatsApp
                </a>
            @endif
            @if($profil->spmb_link)
                <a href="{{ $profil->spmb_link }}" target="_blank"
                   class="bg-white text-blue-900 font-semibold px-8 py-3 rounded-full hover:bg-blue-100 transition">
                    Daftar Sekarang
                </a>
            @endif
        </div>
    </div>
</section>

@endsection