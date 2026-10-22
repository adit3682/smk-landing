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
    $mitra       = $baris($profil?->spmb_mitra);
    $gelombang   = array_map(fn ($b) => array_pad(array_map('trim', explode('|', $b)), 3, ''), $baris($profil?->spmb_gelombang));
    $testimoni   = array_map(fn ($b) => array_pad(array_map('trim', explode('|', $b, 3)), 3, ''), $baris($profil?->spmb_testimoni));
    $warnaGelombang = [['bg-amber-400', 'text-amber-600'], ['bg-brand-500', 'text-brand-600'], ['bg-emerald-500', 'text-emerald-600']];

    // Poster / brosur yang di-upload admin
    $posters   = array_values(array_filter((array) ($profil?->spmb_posters ?? [])));
    $namaFile  = fn ($path, $i) => 'Brosur-SPMB-' . Str::slug($profil?->spmb_tahun_ajaran ?: 'sekolah') . '-' . ($i + 1) . '.' . (pathinfo($path, PATHINFO_EXTENSION) ?: 'jpg');
    // Hanya 1 poster ditampilkan; semua brosur/poster digabung dalam 1 file PDF untuk diunduh
    $poster1    = $posters[0] ?? null;
    $pdf        = $profil?->spmb_brosur_pdf;
    $linkUnduh  = $pdf ? Storage::url($pdf) : ($poster1 ? Storage::url($poster1) : null);
    $namaUnduh  = $pdf ? 'Brosur-SPMB-' . Str::slug($profil?->spmb_tahun_ajaran ?: 'sekolah') . '.pdf'
                       : ($poster1 ? $namaFile($poster1, 0) : null);
    $labelUnduh = $pdf ? 'Unduh PDF' : 'Unduh Brosur';
    $linkDaftar = $profil?->spmb_link ?: '#daftar';
    $adaSarpras = isset($sarpras) && $sarpras->count();
    $adaMitra   = count($mitra) > 0;
@endphp

{{-- ========== HERO ========== --}}
<section class="relative pt-32 pb-24 md:pt-36 md:pb-28 px-6 text-white overflow-hidden grain">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800"></div>
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 20%, rgba(89,166,255,.4) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(51,128,255,.2) 0%, transparent 45%);"></div>
    <div class="absolute inset-0 opacity-[0.06]" style="background-image: linear-gradient(rgba(255,255,255,.12) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.12) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center">
        @if($profil?->spmb_tahun_ajaran)
            <div class="inline-flex items-center gap-2 bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-semibold px-4 py-1.5 rounded-full mb-6 backdrop-blur-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Penerimaan Murid Baru &middot; Tahun Ajaran {{ $profil->spmb_tahun_ajaran }}
            </div>
        @endif

        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-[1.08] tracking-tight mb-4"><span class="text-gradient">SPMB</span></h1>
        <p class="text-xl sm:text-2xl font-semibold text-brand-100 mb-3">Sistem Penerimaan Murid Baru</p>
        <p class="text-brand-200/80 text-base sm:text-lg max-w-xl mx-auto mb-10">
            {{ $profil->nama_sekolah ?? '' }} — mencetak talenta digital masa depan Indonesia.
        </p>

        <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-3 mb-10">
            <a href="{{ $linkDaftar }}" @if($profil?->spmb_link) target="_blank" rel="noopener" @endif
               class="inline-flex items-center gap-2 bg-white text-brand-900 font-bold px-8 py-4 rounded-xl shadow-glow hover:scale-[1.03] transition-all">
                Daftar Sekarang <span aria-hidden="true">&rarr;</span>
            </a>
            <a href="#jurusan" class="inline-flex items-center gap-2 text-white font-medium px-6 py-4 rounded-xl border border-white/25 hover:bg-white/10 transition">
                Lihat Program Keahlian
            </a>
            @if($linkUnduh)
                <a href="{{ $linkUnduh }}" download="{{ $namaUnduh }}"
                   class="inline-flex items-center gap-2 text-white font-medium px-6 py-4 rounded-xl border border-white/25 hover:bg-white/10 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    {{ $labelUnduh }}
                </a>
            @endif
        </div>

        <div class="flex flex-wrap justify-center gap-3">
            @if($profil?->spmb_biaya)
                <div class="bg-white/10 border border-white/15 backdrop-blur-sm rounded-full px-4 py-2 text-sm font-medium">
                    Biaya Pendaftaran <span class="text-emerald-300 font-bold">{{ $profil->spmb_biaya }}</span>
                </div>
            @endif
            @if($profil?->spmb_promo)
                <div class="bg-white/10 border border-white/15 backdrop-blur-sm rounded-full px-4 py-2 text-sm font-bold text-amber-300">
                    {{ $profil->spmb_promo }}
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ========== PROGRAM KEAHLIAN (otomatis dari data Jurusan) ========== --}}
@if($jurusans->count())
    <section id="jurusan" data-fade-in class="py-24 px-6 bg-slate-50 opacity-0 translate-y-8 transition duration-700 scroll-mt-24">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Pilih Sesuai Bakatmu</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight">Program Keahlian</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jurusans as $jurusan)
                    @php
                        $singkatan = collect(preg_split('/\s+/', trim($jurusan->nama)))
                            ->reject(fn ($k) => in_array(strtolower($k), ['dan', '&', 'dengan']))
                            ->map(fn ($k) => strtoupper(substr($k, 0, 1)))
                            ->implode('');
                        if (strlen($singkatan) < 2) { $singkatan = strtoupper($jurusan->nama); }
                        $poin = collect($jurusan->keterampilan_list)->take(4)->map(fn ($k) => trim(Str::before($k, ':')))->filter()->values();
                    @endphp
                    <a href="{{ route('jurusan.show', $jurusan->slug) }}" data-tema="{{ $jurusan->tema_key }}"
                       class="card-lift group flex flex-col bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                        <div class="h-36 bg-gradient-to-br from-accent-600 to-accent-800 flex items-center justify-center relative">
                            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 30% 70%, white 0%, transparent 50%);"></div>
                            <div class="relative text-center">
                                <div class="text-white font-extrabold text-2xl tracking-tight">{{ $singkatan }}</div>
                                @if($singkatan !== strtoupper($jurusan->nama))
                                    <div class="text-accent-200 text-xs mt-1 px-4">{{ $jurusan->nama }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col flex-1 p-6">
                            @if($poin->count())
                                <ul class="space-y-2 text-sm text-slate-600 mb-5">
                                    @foreach($poin as $p)
                                        <li class="flex items-start gap-2"><span class="text-accent-500 mt-0.5">&bull;</span> {{ $p }}</li>
                                    @endforeach
                                </ul>
                            @elseif($jurusan->deskripsi)
                                <p class="text-sm text-slate-600 mb-5 leading-relaxed">{{ Str::limit($jurusan->deskripsi, 110) }}</p>
                            @endif
                            <span class="mt-auto text-accent-600 font-semibold text-sm inline-flex items-center gap-1 group-hover:gap-2 transition-all">
                                Detail jurusan <span aria-hidden="true">&rarr;</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ========== PERSYARATAN & EKSTRAKURIKULER ========== --}}
@if(count($persyaratan) || count($ekskul))
    <section id="persyaratan" data-fade-in class="py-20 px-6 bg-white opacity-0 translate-y-8 transition duration-700 scroll-mt-24">
        <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-10">

            @if(count($persyaratan))
                <div>
                    <div class="inline-flex items-center gap-2 text-brand-600 font-semibold text-sm tracking-wide uppercase mb-4">
                        <span class="w-8 h-px bg-brand-400"></span> Persyaratan Pendaftaran
                    </div>
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
                    <div class="inline-flex items-center gap-2 text-brand-600 font-semibold text-sm tracking-wide uppercase mb-4">
                        <span class="w-8 h-px bg-brand-400"></span> Ekstrakurikuler
                    </div>
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

{{-- ========== GELOMBANG ========== --}}
@if(count($gelombang))
    <section id="gelombang" data-fade-in class="py-20 px-6 bg-slate-50 opacity-0 translate-y-8 transition duration-700 scroll-mt-24">
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

{{-- ========== BROSUR & POSTER (1 poster + unduh PDF) ========== --}}
@if($poster1 || $pdf)
    <section id="brosur" data-fade-in class="py-20 px-6 bg-white opacity-0 translate-y-8 transition duration-700 scroll-mt-24">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Informasi Lengkap</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight">Brosur &amp; Poster SPMB</h2>
                <p class="mt-3 text-slate-500 max-w-md mx-auto">Unduh untuk dibaca, dicetak, atau dibagikan ke keluarga dan teman.</p>
            </div>

            <div class="max-w-md mx-auto card-lift bg-slate-50 border border-slate-100 rounded-2xl p-4 shadow-sm">
                @if($poster1)
                    <img src="{{ Storage::url($poster1) }}" alt="Poster SPMB" loading="lazy" decoding="async"
                         class="w-full rounded-xl shadow-card">
                @else
                    <div class="aspect-[3/4] rounded-xl bg-gradient-to-br from-brand-800 to-brand-600 flex items-center justify-center text-white font-bold text-lg">
                        Brosur SPMB (PDF)
                    </div>
                @endif
                @if($linkUnduh)
                    <a href="{{ $linkUnduh }}" download="{{ $namaUnduh }}"
                       class="mt-4 flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-6 py-3 rounded-xl shadow-glow transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        {{ $labelUnduh }}
                    </a>
                    @if($pdf)
                        <p class="mt-2 text-center text-xs text-slate-400">Berisi seluruh brosur &amp; poster SPMB</p>
                    @endif
                @endif
            </div>
        </div>
    </section>
@endif

{{-- ========== PRESTASI ========== --}}
@if(count($prestasi))
    <section data-fade-in class="py-20 px-6 bg-slate-50 opacity-0 translate-y-8 transition duration-700">
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

{{-- ========== FASILITAS + MITRA ========== --}}
@if($adaSarpras || $adaMitra)
    <section data-fade-in class="py-20 px-6 bg-white opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto grid {{ ($adaSarpras && $adaMitra) ? 'lg:grid-cols-2' : '' }} gap-12">

            @if($adaSarpras)
                <div>
                    <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Fasilitas Sekolah</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Lingkungan Belajar yang Lengkap</h2>
                    <div class="grid grid-cols-2 {{ $adaMitra ? '' : 'md:grid-cols-3' }} gap-3">
                        @foreach($sarpras as $item)
                            <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-100">
                                @if(!empty($item->foto))
                                    <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}" loading="lazy" decoding="async"
                                         class="w-full h-24 object-cover">
                                @endif
                                <div class="p-3 text-center text-sm font-semibold text-brand-950">{{ $item->nama }}</div>
                            </div>
                        @endforeach
                    </div>
                    @if(\Illuminate\Support\Facades\Route::has('fasilitas'))
                        <a href="{{ route('fasilitas') }}" class="inline-flex items-center gap-1 mt-5 text-sm font-semibold text-brand-600 hover:gap-2 transition-all">
                            Lihat semua fasilitas <span aria-hidden="true">&rarr;</span>
                        </a>
                    @endif
                </div>
            @endif

            @if($adaMitra)
                <div>
                    <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Mitra Kami</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Didukung Industri</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($mitra as $nama)
                            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 flex items-center justify-center text-center h-20 {{ ($loop->last && count($mitra) % 2 === 1) ? 'col-span-2' : '' }}">
                                <span class="font-bold text-slate-500 text-sm tracking-wide">{{ $nama }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
@endif

{{-- ========== KATA ALUMNI ========== --}}
@if(count($testimoni))
    <section data-fade-in class="py-20 px-6 bg-slate-50 opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Kata Alumni</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight">Mereka Sudah Membuktikan</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($testimoni as [$kutipan, $nama, $ket])
                    <div class="card-lift bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col">
                        <p class="text-slate-600 text-sm leading-relaxed mb-5">&ldquo;{{ trim($kutipan, " \t\n\r\0\x0B\"“”") }}&rdquo;</p>
                        <div class="mt-auto">
                            <div class="font-bold text-brand-950 text-sm">{{ $nama }}</div>
                            @if($ket)<div class="text-xs text-slate-500 mt-0.5">{{ $ket }}</div>@endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ========== CARA PENDAFTARAN ========== --}}
<section data-fade-in class="py-20 px-6 bg-white opacity-0 translate-y-8 transition duration-700">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-10">
            <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Mudah &amp; Cepat</p>
            <h2 class="text-3xl font-extrabold text-brand-950 tracking-tight">Cara Pendaftaran</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['Siapkan Dokumen', 'Lengkapi dokumen sesuai persyaratan pendaftaran.'],
                ['Isi Formulir Pendaftaran', 'Klik "Daftar Sekarang" atau hubungi panitia via WhatsApp.'],
                ['Konfirmasi & Daftar Ulang', 'Panitia akan menghubungi untuk proses selanjutnya.'],
            ] as $i => [$judul, $isi])
                <div class="card-lift bg-slate-50 rounded-2xl p-6 text-center border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-full bg-brand-600 text-white font-bold flex items-center justify-center mx-auto mb-4">{{ $i + 1 }}</div>
                    <h3 class="font-bold text-brand-950 mb-2">{{ $judul }}</h3>
                    <p class="text-sm text-slate-600">{{ $isi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== CTA DAFTAR ========== --}}
<section id="daftar" data-fade-in class="py-20 px-6 opacity-0 translate-y-8 transition duration-700 scroll-mt-24">
    <div class="max-w-5xl mx-auto relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-600 via-brand-700 to-brand-950 px-8 py-14 md:py-16 text-center text-white">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 30%, #8ec7ff 0%, transparent 50%);"></div>
        <div class="relative">
            @if($profil?->spmb_biaya)
                <div class="inline-flex items-center gap-2 bg-white/15 border border-white/20 text-white text-xs font-semibold px-3.5 py-1.5 rounded-full mb-5">
                    Biaya Pendaftaran {{ $profil->spmb_biaya }}
                </div>
            @endif
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-3">Siap Bergabung dengan {{ $profil->nama_sekolah ?? 'Kami' }}?</h2>
            <p class="text-brand-100 max-w-md mx-auto mb-8 text-sm md:text-base">
                {{ $profil?->spmb_promo ?: 'Punya pertanyaan? Tim kami siap membantu proses pendaftaranmu.' }}
            </p>

            <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-3 mb-8">
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
                @if($linkUnduh)
                    <a href="{{ $linkUnduh }}" download="{{ $namaUnduh }}"
                       class="inline-flex items-center gap-2 border border-white/30 text-white font-semibold px-8 py-4 rounded-xl hover:bg-white/10 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        {{ $labelUnduh }}
                    </a>
                @endif
            </div>

            @if($profil?->spmb_whatsapp || $profil?->alamat)
                <div class="flex flex-col sm:flex-row items-center justify-center gap-x-6 gap-y-2 text-sm text-brand-200">
                    @if($profil?->spmb_whatsapp)
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            {{ $profil->spmb_whatsapp }}
                        </span>
                    @endif
                    @if($profil?->alamat)
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $profil->alamat }}
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

@endsection