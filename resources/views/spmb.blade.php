@extends('layouts.app')

@section('title', 'SPMB - Sistem Penerimaan Murid Baru')

@section('content')
@php
    // Ubah nomor WhatsApp apa pun (0812-xxxx, +62812xxx, dll) jadi format 62812xxx untuk wa.me
    $wa = preg_replace('/\D/', '', $profil->spmb_whatsapp ?? '');
    if ($wa !== '' && str_starts_with($wa, '0')) {
        $wa = '62' . substr($wa, 1);
    }

    $adaInfo = $profil && ($profil->spmb_poster || $profil->spmb_link || $wa !== '');
@endphp

<div class="pt-32 pb-20 px-6 max-w-5xl mx-auto">

    <div class="text-center mb-12">
        <span class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Informasi Pendaftaran</span>
        <h1 class="text-4xl font-extrabold text-blue-950 mt-2 mb-3">SPMB</h1>
        <p class="text-slate-600 max-w-2xl mx-auto">
            Sistem Penerimaan Murid Baru {{ $profil->nama_sekolah ?? 'SMK TI Bina Citra Informatika Purwokerto' }}.
        </p>
    </div>

    @if($adaInfo)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            {{-- Poster --}}
            <div>
                @if($profil->spmb_poster)
                    <a href="{{ Storage::url($profil->spmb_poster) }}" target="_blank" class="block group relative">
                        <img src="{{ Storage::url($profil->spmb_poster) }}"
                             alt="Poster SPMB"
                             class="w-full rounded-2xl border border-blue-100 shadow-sm group-hover:opacity-90 transition">
                        <span class="absolute bottom-3 right-3 bg-blue-900/90 text-white text-xs px-3 py-1.5 rounded-full opacity-0 group-hover:opacity-100 transition">
                            Klik untuk perbesar
                        </span>
                    </a>
                @else
                    <div class="w-full aspect-[3/4] bg-blue-50 rounded-2xl flex items-center justify-center text-slate-400 text-sm">
                        Poster belum tersedia
                    </div>
                @endif
            </div>

            {{-- Info & tombol --}}
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-blue-950 mb-2">Cara Mendaftar</h2>
                    <p class="text-slate-600 text-sm leading-6">
                        Baca poster untuk jadwal dan persyaratan, lalu daftar lewat tautan di bawah ini.
                        Kalau ada pertanyaan, hubungi panitia melalui WhatsApp.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    @if($profil->spmb_link)
                        <a href="{{ $profil->spmb_link }}" target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center bg-blue-900 text-white font-semibold px-6 py-3 rounded-full hover:bg-blue-800 transition">
                            Buka Link Pendaftaran
                        </a>
                    @endif

                    @if($wa !== '')
                        <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center bg-green-600 text-white font-semibold px-6 py-3 rounded-full hover:bg-green-700 transition">
                            Hubungi via WhatsApp
                        </a>
                    @endif
                </div>
            </div>

        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">📢</span>
            </div>
            <p class="text-slate-500 font-medium">Informasi SPMB belum tersedia</p>
            <p class="text-slate-400 text-sm mt-1">Pantau terus halaman ini untuk info pendaftaran.</p>
        </div>
    @endif

</div>
@endsection