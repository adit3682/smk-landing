@extends('layouts.app')

@section('title', 'Profil Sekolah Lengkap')

@section('content')
@php
    // Struktur Yayasan: satu baris = "Nama | Jabatan"
    $pengurusYayasan = collect(preg_split('/\R/', (string) ($profilSekolah?->struktur_yayasan)))
        ->map(fn ($b) => array_map('trim', array_pad(explode('|', $b), 2, '')))
        ->filter(fn ($x) => $x[0] !== '')
        ->values();

    // Video profil (YouTube): terima link watch, youtu.be, embed, shorts, live, atau ID 11 karakter
    $videoId = null;
    $videoUrl = trim((string) ($profilSekolah?->video_profil_url));
    if ($videoUrl !== '') {
        if (preg_match('~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:[^#]*&)?v=|embed/|shorts/|live/|v/))([A-Za-z0-9_-]{11})~', $videoUrl, $m)) {
            $videoId = $m[1];
        } elseif (preg_match('/^[A-Za-z0-9_-]{11}$/', $videoUrl)) {
            $videoId = $videoUrl;
        }
    }
@endphp

{{-- HEADER HALAMAN --}}
<section class="relative pt-32 pb-16 px-6 text-white overflow-hidden grain">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800"></div>
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 20%, rgba(89,166,255,.4) 0%, transparent 50%);"></div>
    <div class="relative z-10 max-w-5xl mx-auto text-center">
        <p class="text-brand-200 font-semibold text-sm tracking-wide uppercase mb-3">Tentang Kami</p>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight"><span class="text-gradient">Profil Sekolah</span></h1>
        <p class="text-brand-200/80 mt-4 max-w-xl mx-auto">{{ $profilSekolah->nama_sekolah ?? '' }}</p>
    </div>
</section>

<div class="py-16 px-6 max-w-5xl mx-auto">

    {{-- DATA UMUM --}}
    <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Informasi</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Data Umum</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([
                ['Nama Sekolah', $profilSekolah->nama_sekolah ?? '-'],
                ['NPSN', $profilSekolah->npsn ?? '-'],
                ['Alamat', $profilSekolah->alamat ?? '-'],
                ['Kepala Sekolah', $profilSekolah->nama_kepala_sekolah ?? '-'],
            ] as [$label, $nilai])
                <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                    <div class="text-xs font-semibold text-brand-600 uppercase tracking-wide">{{ $label }}</div>
                    <div class="font-bold text-brand-950 mt-1">{{ $nilai }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- SAMBUTAN KEPALA SEKOLAH --}}
    @if($profilSekolah?->sambutan_kepala_sekolah)
        <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
            <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Pesan</p>
            <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Sambutan Kepala Sekolah</h2>
            <div class="bg-gradient-to-br from-brand-50 to-white border border-brand-100 rounded-3xl p-6 md:p-8 flex flex-col md:flex-row gap-6 items-center md:items-start">

                @if($profilSekolah->foto_kepala_sekolah)
                    <img src="{{ Storage::url($profilSekolah->foto_kepala_sekolah) }}"
                         alt="{{ $profilSekolah->nama_kepala_sekolah }}"
                         loading="lazy" decoding="async"
                         class="w-32 h-32 rounded-2xl object-cover object-top shadow-card flex-shrink-0">
                @else
                    <div class="w-32 h-32 rounded-2xl bg-brand-100 flex items-center justify-center text-brand-400 font-bold text-3xl flex-shrink-0">
                        {{ strtoupper(substr($profilSekolah->nama_kepala_sekolah ?? 'K', 0, 1)) }}
                    </div>
                @endif

                <div class="text-center md:text-left">
                    <p class="text-slate-600 leading-relaxed mb-4 border-l-2 border-brand-200 pl-4 text-left">
                        {!! nl2br(e($profilSekolah->sambutan_kepala_sekolah)) !!}
                    </p>
                    <div class="font-bold text-brand-950">{{ $profilSekolah->nama_kepala_sekolah ?? '-' }}</div>
                    <div class="text-sm text-slate-500">Kepala Sekolah</div>
                </div>
            </div>
        </section>
    @endif

    {{-- VIDEO PROFIL (YouTube, dimuat saat diklik) --}}
    @if($videoId)
        <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
            <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Video</p>
            <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Profil {{ $profilSekolah->nama_sekolah ?? 'Sekolah' }}</h2>

            <div x-data="{ putar: false }" class="relative aspect-video rounded-3xl overflow-hidden shadow-card border border-brand-100 bg-brand-950">
                <template x-if="!putar">
                    <button type="button" @click="putar = true"
                            class="group absolute inset-0 w-full h-full cursor-pointer"
                            aria-label="Putar video profil sekolah">
                        <img src="https://i.ytimg.com/vi/{{ $videoId }}/hqdefault.jpg" alt=""
                             loading="lazy" decoding="async"
                             class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute inset-0 bg-gradient-to-t from-brand-950/60 via-brand-950/10 to-transparent"></span>
                        <span class="absolute inset-0 flex items-center justify-center">
                            <span class="w-20 h-20 rounded-full bg-white/95 text-brand-700 flex items-center justify-center shadow-glow group-hover:scale-110 transition">
                                <svg class="w-8 h-8 ml-1" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                        </span>
                        <span class="absolute bottom-4 left-5 text-white text-sm font-semibold">Tonton video profil</span>
                    </button>
                </template>
                <template x-if="putar">
                    <iframe class="absolute inset-0 w-full h-full"
                            src="https://www.youtube-nocookie.com/embed/{{ $videoId }}?autoplay=1&rel=0"
                            title="Video profil {{ $profilSekolah->nama_sekolah ?? 'sekolah' }}"
                            allow="accelerometer; autoplay; encrypted-media; picture-in-picture; fullscreen"
                            allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </template>
            </div>
        </section>
    @endif

    {{-- VISI MISI --}}
    <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Arah Kami</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Visi &amp; Misi</h2>

        <div class="bg-brand-950 text-white rounded-2xl p-6 md:p-8 mb-5">
            <div class="text-brand-300 text-xs font-semibold uppercase tracking-wide mb-2">Visi</div>
            <p class="text-brand-50 leading-relaxed">{{ $profilSekolah->visi ?? '-' }}</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl p-6 md:p-8 shadow-sm">
            <div class="text-brand-600 text-xs font-semibold uppercase tracking-wide mb-4">Misi</div>
            <ul class="space-y-3">
                @forelse(($profilSekolah->misi ?? []) as $i => $poin)
                    <li class="flex items-start gap-3 text-slate-600">
                        <span class="mt-0.5 w-6 h-6 rounded-lg bg-brand-100 text-brand-600 text-xs font-bold flex items-center justify-center shrink-0">{{ $i + 1 }}</span>
                        <span>{{ $poin }}</span>
                    </li>
                @empty
                    <li class="text-slate-400 text-sm">Belum ada data misi.</li>
                @endforelse
            </ul>
        </div>
    </section>

    {{-- GRAFIK TREN SISWA --}}
    <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Perkembangan</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Tren Jumlah Siswa</h2>
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <canvas id="chartSiswa" height="100"></canvas>
        </div>
    </section>

    <!-- {{-- STAF TU --}}
    <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Tim Kami</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Staf Tata Usaha</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($stafs as $staf)
                <div class="bg-white border border-slate-100 rounded-2xl p-3 text-center shadow-sm">
                    @if(!empty($staf->foto))
                        <img src="{{ Storage::url($staf->foto) }}" alt="{{ $staf->nama }}"
                             loading="lazy" decoding="async"
                             class="w-full aspect-square object-cover rounded-xl mb-3">
                    @else
                        <div class="w-full aspect-square bg-brand-100 rounded-xl mb-3 flex items-center justify-center text-brand-400 font-bold text-xl">
                            {{ substr($staf->nama, 0, 1) }}
                        </div>
                    @endif
                    <div class="text-sm font-semibold text-brand-950">{{ $staf->nama }}</div>
                    <div class="text-xs text-slate-500">{{ $staf->jabatan }}</div>
                </div>
            @empty
                <p class="text-slate-400 text-sm col-span-4">Belum ada data staf.</p>
            @endforelse
        </div>
    </section> -->

    {{-- TAUTAN FASILITAS --}}
    <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Fasilitas</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Sarana &amp; Prasarana</h2>

        @php
            // 3 foto fasilitas (diambil dari data Fasilitas yang sudah ada)
            $fotoFasilitas = collect($sarpras ?? [])->filter(fn ($x) => !empty($x->foto))->take(3)->values();
        @endphp
        @if($fotoFasilitas->count())
            <style>
                .fas-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 32px; }
                .fas-item { position: relative; display: block; overflow: hidden; border-radius: 16px; background: #d9ebff;
                            aspect-ratio: 3 / 4; box-shadow: 0 1px 2px rgba(15,23,42,.08); }
                .fas-item img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
                .fas-item:hover img { transform: scale(1.05); }
                .fas-item .fas-shade { position: absolute; inset: 0; background: linear-gradient(to top, rgba(20,34,87,.8), rgba(20,34,87,.1) 55%, transparent); opacity: .85; transition: opacity .3s; }
                .fas-item:hover .fas-shade { opacity: 1; }
                .fas-item .fas-nama { position: absolute; left: 0; right: 0; bottom: 0; padding: 12px; color: #fff; font-size: 12px; font-weight: 600; line-height: 1.3; }
                @media (min-width: 768px) {
                    .fas-grid { gap: 20px; }
                    .fas-item { aspect-ratio: 4 / 3; }
                    .fas-item .fas-nama { padding: 16px; font-size: 14px; }
                }
            </style>
            <div class="fas-grid">
                @foreach($fotoFasilitas as $f)
                    <a href="{{ route('fasilitas') }}" class="fas-item">
                        <img src="{{ Storage::url($f->foto) }}" alt="{{ $f->nama }}" loading="lazy" decoding="async">
                        <span class="fas-shade"></span>
                        <span class="fas-nama">{{ $f->nama }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        <a href="{{ route('fasilitas') }}"
           class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-7 py-3.5 rounded-xl shadow-glow transition">
            Lihat fasilitas sekolah <span aria-hidden="true">&rarr;</span>
        </a>
    </section>

    {{-- AKREDITASI --}}
    <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Pengakuan</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-6">Akreditasi</h2>
        @if($akreditasi)
            <div class="flex w-full items-center gap-5 bg-gradient-to-br from-brand-900 to-brand-950 text-white px-6 md:px-8 py-6 rounded-2xl shadow-card">
                @if($akreditasi->logo)
                    <div class="w-16 h-16 shrink-0 rounded-2xl bg-white flex items-center justify-center overflow-hidden">
                        <img src="{{ Storage::url($akreditasi->logo) }}" alt="Logo akreditasi {{ $akreditasi->peringkat }}"
                             class="w-full h-full object-contain p-1.5">
                    </div>
                @else
                    <span class="text-4xl font-extrabold">{{ $akreditasi->peringkat }}</span>
                @endif
                <div class="text-sm">
                    <div class="font-semibold text-base">Terakreditasi {{ $akreditasi->peringkat }}</div>
                    <div class="text-brand-200">{{ collect([$akreditasi->lembaga_penerbit, $akreditasi->tahun_ditetapkan ? 'Ditetapkan ' . $akreditasi->tahun_ditetapkan : null])->filter()->implode(' · ') }}</div>
                </div>
            </div>
        @else
            <p class="text-slate-400 text-sm">Belum ada data akreditasi.</p>
        @endif
    </section>

    {{-- STRUKTUR ORGANISASI --}}
    <section data-fade-in class="mb-20 opacity-0 translate-y-8 transition duration-700">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Organisasi</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-8">Struktur Organisasi</h2>

        @if(!empty($profilSekolah?->struktur_gambar))
            @php $gambarStruktur = \Illuminate\Support\Facades\Storage::url($profilSekolah->struktur_gambar); @endphp
            <div x-data="{ buka: false }" @keydown.escape.window="buka = false">
                <button type="button" @click="buka = true"
                        class="group relative block w-full rounded-2xl overflow-hidden border border-brand-100 shadow-card bg-white cursor-zoom-in">
                    <img src="{{ $gambarStruktur }}" alt="Struktur Organisasi {{ $profilSekolah->nama_sekolah ?? '' }}"
                         loading="lazy" decoding="async" class="w-full h-auto block">
                    <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-full bg-brand-950/80 backdrop-blur text-white text-xs font-semibold px-3 py-1.5 group-hover:bg-brand-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 8v6M8 11h6m6 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Perbesar
                    </span>
                </button>

                {{-- Layar penuh: di HP bisa digeser untuk melihat detail --}}
                <div x-show="buka" style="display:none" x-transition.opacity
                     class="fixed inset-0 z-[100] bg-slate-900/95 backdrop-blur-sm flex flex-col"
                     role="dialog" aria-modal="true" aria-label="Struktur Organisasi">
                    <div class="flex items-center justify-between px-5 py-4 text-white shrink-0">
                        <span class="font-bold text-sm">Struktur Organisasi</span>
                        <div class="flex items-center gap-2">
                            <a href="{{ $gambarStruktur }}" download
                               class="rounded-full bg-white/10 border border-white/20 hover:bg-white/20 transition text-xs font-semibold px-3 py-2">Unduh</a>
                            <button type="button" @click="buka = false" aria-label="Tutup"
                                    class="w-9 h-9 rounded-full bg-white/10 border border-white/20 hover:bg-white/20 transition flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex-1 overflow-auto px-4 pb-6" @click.self="buka = false">
                        <img src="{{ $gambarStruktur }}" alt="Struktur Organisasi"
                             class="mx-auto h-auto rounded-xl min-w-[900px] max-w-none lg:min-w-0 lg:max-w-full">
                    </div>
                </div>
            </div>
        @else
        {{-- Desktop: tree dengan garis penghubung --}}
        <div class="hidden md:flex flex-col items-center">
            @if($struktur->count() > 0)
                <div class="bg-brand-900 text-white px-6 py-3 rounded-xl font-semibold shadow-card text-center">
                    {{ $struktur->first()->jabatan }}
                    <div class="text-xs font-normal text-brand-200 mt-0.5">{{ $struktur->first()->nama_pejabat }}</div>
                </div>

                @if($struktur->count() > 1)
                    <div class="w-px h-8 bg-brand-200"></div>

                    <div class="relative flex justify-center w-full max-w-2xl">
                        <div class="absolute top-0 h-px bg-brand-200" style="left: 12.5%; right: 12.5%;"></div>

                        <div class="flex justify-between w-full gap-4 pt-8">
                            @foreach($struktur->skip(1) as $s)
                                <div class="flex flex-col items-center relative flex-1">
                                    <div class="absolute -top-8 w-px h-8 bg-brand-200"></div>
                                    <div class="bg-brand-50 border border-brand-100 text-brand-950 px-4 py-2 rounded-xl text-center">
                                        <div class="font-semibold text-sm">{{ $s->jabatan }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $s->nama_pejabat }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <p class="text-slate-400 text-sm">Belum ada data struktur organisasi.</p>
            @endif
        </div>

        {{-- Mobile: accordion --}}
        <div class="md:hidden space-y-2" x-data="{ open: null }">
            @foreach($struktur as $i => $s)
                <div class="border border-brand-100 rounded-xl overflow-hidden">
                    <button @click="open = open === {{ $i }} ? null : {{ $i }}" class="w-full text-left px-4 py-3 font-semibold text-brand-950 bg-brand-50">
                        {{ $s->jabatan }}
                    </button>
                    <div x-show="open === {{ $i }}" class="px-4 py-3 text-sm text-slate-600">
                        {{ $s->nama_pejabat }}
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </section>

    {{-- PROFIL YAYASAN --}}
    <section data-fade-in class="opacity-0 translate-y-8 transition duration-700">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Yayasan</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-4">Profil Yayasan</h2>

        @if($profilSekolah?->profil_yayasan)
            <p class="text-slate-600 leading-relaxed">{!! nl2br(e($profilSekolah->profil_yayasan)) !!}</p>
        @elseif($pengurusYayasan->isEmpty())
            <p class="text-slate-400 text-sm">Belum ada data profil yayasan.</p>
        @endif

        @if($pengurusYayasan->count())
            <h3 class="text-lg font-bold text-brand-950 mt-10 mb-5">Struktur Yayasan</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($pengurusYayasan as [$nama, $jabatan])
                    <div class="card-lift flex items-center gap-4 bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                        <div class="w-12 h-12 shrink-0 rounded-xl bg-brand-600 text-white font-bold flex items-center justify-center">
                            {{ strtoupper(substr(preg_replace('/^(Drs\.|Dr\.|Ir\.|H\.|Hj\.)\s*/i', '', $nama), 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-brand-950 leading-snug">{{ $nama }}</div>
                            @if($jabatan)
                                <div class="text-sm text-brand-600 font-medium mt-0.5">{{ $jabatan }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartSiswa');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dataSiswa->pluck('tahun_ajaran')) !!},
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: {!! json_encode($dataSiswa->pluck('jumlah')) !!},
                        borderColor: '#1a5cf5',
                        backgroundColor: 'rgba(26,92,245,0.1)',
                        tension: 0.3,
                        fill: true,
                    }]
                },
                options: { plugins: { legend: { display: false } } }
            });
        }
    });
</script>
@endsection