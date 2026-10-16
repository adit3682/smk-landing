@extends('layouts.app')

@section('title', $jurusan->nama)

@section('content')
@php
    use Illuminate\Support\Str;

    $keterampilan = $jurusan->keterampilan_list;
    $prospek      = $jurusan->prospek_list;
    $kegiatans    = $jurusan->kegiatans;

    // Angka ringkas: hanya yang punya data (tidak ada klaim yang dikarang)
    $stats = collect([
        ['3 Tahun', 'Durasi pendidikan'],
        count($keterampilan) ? [count($keterampilan), 'Keterampilan dipelajari'] : null,
        $kegiatans->count()  ? [$kegiatans->count(), 'Kegiatan terdokumentasi'] : null,
        count($prospek) > 1  ? [count($prospek), 'Jalur karir'] : null,
    ])->filter()->values();
@endphp

{{-- data-tema memilih warna aksen (blue / violet / orange), lihat app.css --}}
<div data-tema="{{ $jurusan->tema_key }}">

    {{-- ========== HERO ========== --}}
    <section class="relative pt-32 pb-20 md:pt-36 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-accent-950 via-accent-900 to-accent-800"></div>
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 75% 25%, rgba(255,255,255,0.25) 0%, transparent 50%);"></div>
        <div class="absolute inset-0 opacity-[0.06]" style="background-image: linear-gradient(rgba(255,255,255,.12) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.12) 1px, transparent 1px); background-size: 40px 40px;"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-6">
            <nav class="flex flex-wrap items-center gap-2 text-sm text-accent-200 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <span aria-hidden="true" class="opacity-50">/</span>
                <a href="{{ route('home') }}#jurusan" class="hover:text-white transition">Program Keahlian</a>
                <span aria-hidden="true" class="opacity-50">/</span>
                <span class="text-white font-medium">{{ $jurusan->nama }}</span>
            </nav>

            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <div class="inline-flex items-center bg-white/10 border border-white/15 text-accent-100 text-xs font-medium px-3.5 py-1.5 rounded-full mb-5 backdrop-blur-sm">
                        Kompetensi Keahlian
                    </div>

                    <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-[1.1] tracking-tight mb-5">
                        {{ $jurusan->nama }}
                    </h1>

                    @if($jurusan->deskripsi)
                        <p class="text-accent-100/90 text-lg leading-relaxed max-w-lg mb-8 whitespace-pre-line">{{ $jurusan->deskripsi }}</p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('spmb') }}"
                           class="inline-flex items-center gap-2 bg-white text-accent-900 font-semibold px-6 py-3.5 rounded-xl shadow-lg hover:scale-[1.02] transition-transform">
                            Daftar jurusan ini
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                        @if(count($keterampilan))
                            <a href="#kompetensi"
                               class="inline-flex items-center gap-2 text-white/90 font-medium px-5 py-3.5 rounded-xl border border-white/20 hover:bg-white/10 transition">
                                Lihat kompetensi
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Foto utama --}}
                <div class="relative">
                    <div class="absolute -inset-4 bg-accent-400/25 blur-3xl rounded-full"></div>
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-white/10 aspect-[4/3] bg-accent-800">
                        @if($jurusan->foto_utama)
                            <img src="{{ Storage::url($jurusan->foto_utama) }}"
                                 alt="{{ $jurusan->nama }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-accent-950/40 via-transparent to-transparent"></div>
                        @elseif($jurusan->icon)
                            <div class="w-full h-full flex items-center justify-center p-12">
                                <img src="{{ Storage::url($jurusan->icon) }}" alt="" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== ANGKA RINGKAS ========== --}}
    <section class="relative -mt-8 z-20 px-6">
        <div class="max-w-5xl mx-auto">
            <div data-reveal class="opacity-0 translate-y-8 transition duration-700 bg-white rounded-2xl shadow-xl shadow-accent-950/10 border border-slate-100 flex divide-x divide-slate-100 overflow-hidden">
                @foreach($stats as [$angka, $label])
                    <div class="flex-1 p-5 md:p-6 text-center">
                        <div class="text-xl md:text-2xl font-extrabold text-accent-950">{{ $angka }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ $label }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========== KURIKULUM ========== --}}
    @if($jurusan->kurikulum)
        <section class="py-20 px-6">
            <div data-reveal class="opacity-0 translate-y-8 transition duration-700 max-w-3xl mx-auto">
                <p class="text-accent-600 font-semibold text-sm mb-2">Tentang jurusan</p>
                <h2 class="text-3xl font-extrabold text-brand-950 tracking-tight mb-5">Kurikulum {{ $jurusan->nama }}</h2>
                <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $jurusan->kurikulum }}</p>
            </div>
        </section>
    @endif

    {{-- ========== KOMPETENSI ========== --}}
    @if(count($keterampilan))
        <section id="kompetensi" class="py-20 px-6 bg-white scroll-mt-24">
            <div class="max-w-6xl mx-auto">
                <div data-reveal class="opacity-0 translate-y-8 transition duration-700 mb-12 max-w-2xl">
                    <p class="text-accent-600 font-semibold text-sm mb-2">Yang akan kamu pelajari</p>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight">Kompetensi utama</h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($keterampilan as $i => $item)
                        @php
                            $judul = trim(Str::before($item, ':'));
                            $isi   = str_contains($item, ':') ? trim(Str::after($item, ':')) : null;
                        @endphp
                        <div data-reveal class="opacity-0 translate-y-8 transition duration-700 flex gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-accent-600 text-white flex items-center justify-center font-bold text-sm">
                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-brand-950 {{ $isi ? 'mb-1' : '' }}">{{ $judul }}</h3>
                                @if($isi)
                                    <p class="text-sm text-slate-500 leading-relaxed">{{ $isi }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ========== KEGIATAN ========== --}}
    @if($kegiatans->count())
        <section class="py-20 px-6 bg-slate-50">
            <div class="max-w-6xl mx-auto">
                <div data-reveal class="opacity-0 translate-y-8 transition duration-700 mb-12 max-w-2xl">
                    <p class="text-accent-600 font-semibold text-sm mb-2">Dokumentasi</p>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight">Kegiatan jurusan</h2>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kegiatans as $kegiatan)
                        <article data-reveal class="opacity-0 translate-y-8 transition duration-700 rounded-2xl bg-white border border-slate-100 overflow-hidden shadow-sm">
                            @if($kegiatan->foto)
                                <img src="{{ Storage::url($kegiatan->foto) }}" alt="{{ $kegiatan->judul }}" loading="lazy" class="w-full h-44 object-cover">
                            @endif
                            <div class="p-5">
                                @if($kegiatan->kategori)
                                    <span class="inline-block text-xs font-semibold text-accent-700 bg-accent-50 rounded-full px-2.5 py-1">{{ $kegiatan->kategori }}</span>
                                @endif
                                <h3 class="font-bold text-brand-950 mt-2">{{ $kegiatan->judul }}</h3>
                                @if($kegiatan->deskripsi)
                                    <p class="text-sm text-slate-600 mt-1 leading-relaxed">{{ $kegiatan->deskripsi }}</p>
                                @endif
                                @if($kegiatan->tanggal)
                                    <p class="text-xs text-slate-400 mt-3">{{ $kegiatan->tanggal->translatedFormat('d F Y') }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ========== PROSPEK KARIR ========== --}}
    @if(count($prospek))
        <section class="py-20 px-6 bg-accent-950 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.35) 0%, transparent 45%);"></div>
            <div class="relative max-w-6xl mx-auto">
                <div data-reveal class="opacity-0 translate-y-8 transition duration-700 mb-12 max-w-2xl">
                    <p class="text-accent-300 font-semibold text-sm mb-2">Setelah lulus</p>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Prospek karir</h2>
                </div>

                @if(count($prospek) > 1)
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($prospek as $item)
                            @php
                                $judul = trim(Str::before($item, ':'));
                                $isi   = str_contains($item, ':') ? trim(Str::after($item, ':')) : null;
                            @endphp
                            <div data-reveal class="opacity-0 translate-y-8 transition duration-700 bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/10">
                                <div class="w-11 h-11 rounded-xl bg-white/10 text-accent-200 flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <h3 class="font-bold text-lg mb-1">{{ $judul }}</h3>
                                @if($isi)
                                    <p class="text-sm text-accent-200">{{ $isi }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div data-reveal class="opacity-0 translate-y-8 transition duration-700 max-w-3xl bg-white/5 border border-white/10 rounded-2xl p-6 md:p-8">
                        <p class="text-accent-100 leading-relaxed whitespace-pre-line">{{ $prospek[0] }}</p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- ========== CTA ========== --}}
    <section class="py-20 px-6">
        <div class="max-w-5xl mx-auto">
            <div data-reveal class="opacity-0 translate-y-8 transition duration-700 relative overflow-hidden rounded-3xl bg-gradient-to-br from-accent-600 via-accent-800 to-accent-950 px-8 py-14 md:py-16 text-center text-white">
                <div class="relative">
                    <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mb-3">
                        Tertarik dengan {{ $jurusan->nama }}?
                    </h2>
                    <p class="text-accent-100 max-w-md mx-auto mb-8 text-sm md:text-base">
                        Daftarkan dirimu sekarang dan mulai perjalananmu bersama kami.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('spmb') }}"
                           class="inline-flex items-center gap-2 bg-white text-accent-900 font-bold px-7 py-3.5 rounded-xl shadow-lg hover:scale-[1.03] transition-transform">
                            Daftar SPMB <span aria-hidden="true">&rarr;</span>
                        </a>
                        <a href="{{ route('home') }}#jurusan"
                           class="inline-flex items-center gap-2 text-white font-medium px-6 py-3.5 rounded-xl border border-white/30 hover:bg-white/10 transition">
                            Lihat jurusan lain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== PROGRAM KEAHLIAN LAINNYA ========== --}}
    @if($lainnya->count())
        <section class="pb-24 px-6">
            <div class="max-w-6xl mx-auto">
                <div data-reveal class="opacity-0 translate-y-8 transition duration-700 mb-8">
                    <p class="text-accent-600 font-semibold text-sm mb-1">Jelajahi juga</p>
                    <h2 class="text-2xl font-extrabold text-brand-950">Program keahlian lainnya</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    @foreach($lainnya as $j)
                        {{-- data-tema di tiap kartu: warna kartu mengikuti jurusannya sendiri --}}
                        <a href="{{ route('jurusan.show', $j->slug) }}" data-tema="{{ $j->tema_key }}" data-reveal
                           class="opacity-0 translate-y-8 transition duration-700 group flex gap-5 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:-translate-y-1 hover:shadow-lg">
                            <div class="w-24 h-24 rounded-xl bg-gradient-to-br from-accent-600 to-accent-900 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                @if($j->icon)
                                    <img src="{{ Storage::url($j->icon) }}" alt="" loading="lazy" class="w-14 h-14 object-contain">
                                @else
                                    <span class="text-white text-2xl font-extrabold">{{ Str::upper(Str::substr($j->nama, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="flex flex-col justify-center min-w-0">
                                <h3 class="font-bold text-brand-950 group-hover:text-accent-600 transition">{{ $j->nama }}</h3>
                                @if($j->deskripsi)
                                    <p class="text-sm text-slate-500 mt-1">{{ Str::limit($j->deskripsi, 90) }}</p>
                                @endif
                                <span class="text-xs font-semibold text-accent-600 mt-2">Lihat detail &rarr;</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

{{-- Animasi muncul: berdiri sendiri supaya tidak bergantung script halaman lain --}}
<script>
    (function () {
        const els = document.querySelectorAll('[data-reveal]');
        const show = el => el.classList.remove('opacity-0', 'translate-y-8');
        if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            els.forEach(show);
            return;
        }
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) { show(e.target); io.unobserve(e.target); }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
        els.forEach(el => io.observe(el));
    })();
</script>
@endsection