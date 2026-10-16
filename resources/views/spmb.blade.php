@extends('layouts.app')

@section('title', 'SPMB - ' . ($profil->nama_sekolah ?? 'Penerimaan Murid Baru'))

@section('content')
@php
    $wa = preg_replace('/\D/', '', $profil?->spmb_whatsapp ?? '');
    if (str_starts_with($wa, '0')) {
        $wa = '62' . substr($wa, 1);
    }

    $baris = fn ($teks) => array_values(array_filter(array_map('trim', explode("\n", (string) $teks))));
    $persyaratan = $baris($profil?->persyaratan_pendaftaran);
    $ekskul      = $baris($profil?->ekstrakurikuler);
    $prestasi    = $baris($profil?->spmb_prestasi);
    $gelombang   = array_map(fn ($b) => array_pad(array_map('trim', explode('|', $b)), 3, ''), $baris($profil?->spmb_gelombang));
    $warnaGelombang = [['bg-amber-400', 'text-amber-600'], ['bg-brand-500', 'text-brand-600'], ['bg-emerald-500', 'text-emerald-600']];
@endphp

{{-- HERO --}}
<section class="relative pt-32 pb-24 px-6 text-white overflow-hidden grain">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800"></div>
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 20%, rgba(89,166,255,.4) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(51,128,255,.2) 0%, transparent 45%);"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center">
        @if($profil?->spmb_tahun_ajaran)
            <span class="inline-block bg-white/10 border border-white/20 text-brand-100 text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
                Tahun Ajaran {{ $profil->spmb_tahun_ajaran }}
            </span>
        @endif

        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight mb-3"><span class="text-gradient">SPMB</span></h1>
        <p class="text-xl font-semibold text-brand-100 mb-3">Sistem Penerimaan Murid Baru</p>
        <p class="text-brand-200/80 max-w-xl mx-auto mb-9">
            {{ $profil->nama_sekolah ?? '' }} — daftarkan dirimu dan jadi bagian dari generasi talenta digital masa depan.
        </p>

        <div class="flex flex-wrap justify-center gap-3 mb-8">
            @if($profil?->spmb_link)
                <a href="{{ $profil->spmb_link }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 bg-white text-brand-900 font-bold px-8 py-4 rounded-xl shadow-glow hover:scale-[1.03] transition-all">
                    Daftar Sekarang <span aria-hidden="true">&rarr;</span>
                </a>
            @endif
            <a href="#jurusan" class="inline-flex items-center text-white font-medium px-6 py-4 rounded-xl border border-white/25 hover:bg-white/10 transition">
                Lihat Program Keahlian
            </a>
        </div>

        <div class="flex flex-wrap justify-center gap-3">
            @if($profil?->spmb_biaya)
                <div class="bg-white/10 border border-white/15 rounded-full px-4 py-2 text-sm font-medium">
                    Biaya Pendaftaran <span class="text-emerald-300 font-bold">{{ $profil->spmb_biaya }}</span>
                </div>
            @endif
            @if($profil?->spmb_promo)
                <div class="bg-white/10 border border-white/15 rounded-full px-4 py-2 text-sm font-medium text-amber-300 font-bold">
                    {{ $profil->spmb_promo }}
                </div>
            @endif
        </div>
    </div>
</section>

{{-- POSTER --}}
@if($profil?->spmb_posters && count($profil->spmb_posters))
    <section class="py-16 px-6 max-w-4xl mx-auto">
        <div class="grid grid-cols-1 {{ count($profil->spmb_posters) > 1 ? 'md:grid-cols-2' : '' }} gap-6">
            @foreach($profil->spmb_posters as $poster)
                <img src="{{ Storage::url($poster) }}" alt="Poster SPMB" loading="lazy" class="w-full rounded-2xl shadow-card">
            @endforeach
        </div>
    </section>
@endif

{{-- PROGRAM KEAHLIAN --}}
@if($jurusans->count())
    <section id="jurusan" data-fade-in class="py-20 px-6 bg-slate-50 opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Pilih Sesuai Bakatmu</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight">Program Keahlian</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jurusans as $jurusan)
                    <a href="{{ route('jurusan.show', $jurusan->slug) }}"
                       class="card-lift group flex flex-col bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                        <div class="aspect-[4/3] overflow-hidden bg-brand-50">
                            @if($jurusan->icon)
                                <img src="{{ Storage::url($jurusan->icon) }}" alt="{{ $jurusan->nama }}" loading="lazy"
                                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-brand-900 to-brand-700 flex items-center justify-center text-white font-extrabold text-5xl">
                                    {{ strtoupper(substr($jurusan->nama, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-lg text-brand-950">{{ $jurusan->nama }}</h3>
                            <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-brand-600 group-hover:gap-2 transition-all">
                                Detail jurusan <span aria-hidden="true">&rarr;</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- PERSYARATAN & EKSTRAKURIKULER --}}
@if(count($persyaratan) || count($ekskul))
    <section data-fade-in class="py-20 px-6 bg-white opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-12">

            @if(count($persyaratan))
                <div>
                    <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Persyaratan Pendaftaran</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Dokumen yang Diperlukan</h2>
                    <ul class="space-y-3">
                        @foreach($persyaratan as $i => $item)
                            <li class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3.5 border border-slate-100">
                                <span class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center shrink-0 text-sm font-bold">{{ $i + 1 }}</span>
                                <span class="text-slate-700 text-sm font-medium">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(count($ekskul))
                <div>
                    <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Ekstrakurikuler</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Kembangkan Bakatmu</h2>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($ekskul as $item)
                            <div class="bg-slate-50 rounded-xl px-4 py-3.5 border border-slate-100 text-sm font-medium text-slate-700">{{ $item }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
@endif

{{-- GELOMBANG --}}
@if(count($gelombang))
    <section data-fade-in class="py-20 px-6 bg-slate-50 opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Jadwal Pendaftaran</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight">Gelombang Pendaftaran</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-5">
                @foreach($gelombang as $i => [$judul, $periode, $ket])
                    @php [$garis, $teks] = $warnaGelombang[$i % 3]; @endphp
                    <div class="card-lift bg-white rounded-2xl p-7 border border-slate-100 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 left-0 right-0 h-1.5 {{ $garis }}"></div>
                        <div class="{{ $teks }} font-bold text-sm mb-2">{{ $judul }}</div>
                        <div class="text-xl font-extrabold text-brand-950 mb-1">{{ $periode }}</div>
                        @if($ket)<p class="text-sm text-slate-500">{{ $ket }}</p>@endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- PRESTASI --}}
@if(count($prestasi))
    <section data-fade-in class="py-20 px-6 bg-white opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Kebanggaan Kami</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight">Prestasi yang Diraih Siswa</h2>
            </div>
            <ul class="space-y-4 bg-gradient-to-br from-brand-50 to-white rounded-2xl border border-brand-100 p-8 md:p-10">
                @foreach($prestasi as $item)
                    <li class="flex items-start gap-3">
                        <span class="mt-1 w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center shrink-0 text-xs font-bold">&#9733;</span>
                        <span class="text-slate-700">{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

{{-- CARA PENDAFTARAN --}}
<section data-fade-in class="py-20 px-6 bg-slate-50 opacity-0 translate-y-8 transition duration-700">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-extrabold text-brand-950 text-center tracking-tight mb-10">Cara Pendaftaran</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['Siapkan Dokumen', 'Lengkapi dokumen sesuai persyaratan pendaftaran.'],
                ['Isi Formulir Pendaftaran', 'Klik "Daftar Sekarang" atau hubungi panitia via WhatsApp.'],
                ['Konfirmasi & Daftar Ulang', 'Panitia akan menghubungi untuk proses selanjutnya.'],
            ] as $i => [$judul, $isi])
                <div class="card-lift bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-full bg-brand-600 text-white font-bold flex items-center justify-center mx-auto mb-4">{{ $i + 1 }}</div>
                    <h3 class="font-bold text-brand-950 mb-2">{{ $judul }}</h3>
                    <p class="text-sm text-slate-600">{{ $isi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section data-fade-in class="py-20 px-6 opacity-0 translate-y-8 transition duration-700">
    <div class="max-w-5xl mx-auto relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-600 via-brand-700 to-brand-950 px-8 py-14 text-center text-white">
        <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-3">Siap Bergabung dengan {{ $profil->nama_sekolah ?? 'Kami' }}?</h2>
        <p class="text-brand-100 max-w-md mx-auto mb-8">Punya pertanyaan? Tim kami siap membantu proses pendaftaranmu.</p>
        <div class="flex flex-wrap justify-center gap-4">
            @if($profil?->spmb_link)
                <a href="{{ $profil->spmb_link }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 bg-white text-brand-900 font-bold px-8 py-4 rounded-xl shadow-lg hover:scale-[1.03] transition-transform">
                    Daftar Online Sekarang <span aria-hidden="true">&rarr;</span>
                </a>
            @endif
            @if($wa)
                <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 border border-white/30 text-white font-semibold px-8 py-4 rounded-xl hover:bg-white/10 transition">
                    Chat WhatsApp
                </a>
            @endif
        </div>
    </div>
</section>

@endsection