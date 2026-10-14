@extends('layouts.app')

@section('title', 'Kontak - ' . ($profilSekolah->nama_sekolah ?? 'SMK Teknologi Informasi'))

@section('content')
@php
    // Ambil hanya alamat src dari kode sematkan Google Maps, lalu bangun iframe sendiri (lebih aman daripada mencetak HTML mentah)
    $petaSrc = null;
    $petaRaw = $profilSekolah?->gmaps_embed;
    if ($petaRaw && preg_match('/src="([^"]+)"/i', $petaRaw, $m)) {
        $src = html_entity_decode($m[1]);
        if (str_contains($src, 'google.com/maps/embed')) {
            $petaSrc = $src;
        }
    }

    // Nomor WhatsApp: 0812... diubah jadi 62812... agar tautan wa.me bisa dibuka
    $wa = preg_replace('/\D/', '', $profilSekolah?->spmb_whatsapp ?? '');
    if (str_starts_with($wa, '0')) {
        $wa = '62' . substr($wa, 1);
    }
@endphp

<div class="pt-32 pb-20 px-6 max-w-5xl mx-auto">
    <h1 class="text-4xl font-extrabold text-blue-950 mb-4 text-center">Hubungi Kami</h1>
    <p class="text-center text-slate-600 mb-12">
        Punya pertanyaan seputar sekolah atau pendaftaran? Silakan hubungi kami lewat kontak di bawah ini.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- INFO KONTAK --}}
        <section data-fade-in class="opacity-0 translate-y-8 transition duration-700 space-y-4">
            <h2 class="text-2xl font-bold text-blue-900 mb-2">Informasi Kontak</h2>

            <div class="bg-white rounded-2xl shadow p-5 border border-blue-100">
                <p class="text-sm font-semibold text-blue-700 mb-1">Alamat</p>
                <p class="text-slate-700">{{ $profilSekolah->alamat ?? 'Alamat belum diisi' }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5 border border-blue-100">
                <p class="text-sm font-semibold text-blue-700 mb-1">Telepon</p>
                @if(!empty($profilSekolah?->telepon))
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $profilSekolah->telepon) }}" class="text-slate-700 hover:text-blue-700">
                        {{ $profilSekolah->telepon }}
                    </a>
                @else
                    <p class="text-slate-500">Belum diisi</p>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow p-5 border border-blue-100">
                <p class="text-sm font-semibold text-blue-700 mb-1">Email</p>
                @if(!empty($profilSekolah?->email))
                    <a href="mailto:{{ $profilSekolah->email }}" class="text-slate-700 hover:text-blue-700">
                        {{ $profilSekolah->email }}
                    </a>
                @else
                    <p class="text-slate-500">Belum diisi</p>
                @endif
            </div>

            @if($wa)
                <div class="bg-white rounded-2xl shadow p-5 border border-blue-100">
                    <p class="text-sm font-semibold text-blue-700 mb-1">WhatsApp</p>
                    <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="text-slate-700 hover:text-blue-700">
                        {{ $profilSekolah->spmb_whatsapp }}
                    </a>
                </div>
            @endif

            @if(!empty($profilSekolah?->instagram) || !empty($profilSekolah?->tiktok))
                <div class="bg-white rounded-2xl shadow p-5 border border-blue-100">
                    <p class="text-sm font-semibold text-blue-700 mb-2">Media Sosial</p>
                    <div class="flex flex-wrap gap-4">
                        @if(!empty($profilSekolah?->instagram))
                            <a href="{{ $profilSekolah->instagram }}" target="_blank" rel="noopener" class="text-slate-700 hover:text-blue-700 font-medium">Instagram</a>
                        @endif
                        @if(!empty($profilSekolah?->tiktok))
                            <a href="{{ $profilSekolah->tiktok }}" target="_blank" rel="noopener" class="text-slate-700 hover:text-blue-700 font-medium">TikTok</a>
                        @endif
                    </div>
                </div>
            @endif
        </section>

        {{-- PETA --}}
        <section data-fade-in class="opacity-0 translate-y-8 transition duration-700">
            <h2 class="text-2xl font-bold text-blue-900 mb-4">Lokasi</h2>
            <div class="rounded-2xl overflow-hidden shadow border border-blue-100 bg-blue-50">
                @if($petaSrc)
                    <iframe src="{{ $petaSrc }}" class="w-full h-80" style="border:0" allowfullscreen loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                @else
                    <div class="h-80 flex items-center justify-center text-slate-500">Peta belum tersedia</div>
                @endif
            </div>
        </section>

    </div>
</div>
@endsection