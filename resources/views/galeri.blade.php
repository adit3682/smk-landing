@extends('layouts.app')

@section('title', 'Galeri - ' . ($profilSekolah->nama_sekolah ?? 'SMK'))

@section('content')

{{-- HEADER HALAMAN --}}
<section class="relative pt-32 pb-16 px-6 text-white overflow-hidden grain">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800"></div>
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 20%, rgba(89,166,255,.4) 0%, transparent 50%);"></div>
    <div class="relative z-10 max-w-3xl mx-auto text-center">
        <p class="text-brand-200 font-semibold text-sm tracking-wide uppercase mb-3">Dokumentasi</p>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight"><span class="text-gradient">Galeri Kegiatan</span></h1>
        <p class="text-brand-200/80 mt-4 leading-relaxed">
            Momen berharga dari kegiatan belajar, lomba, dan kebersamaan di
            <strong class="text-white">{{ $profilSekolah->nama_sekolah ?? 'sekolah kami' }}</strong>.
        </p>
    </div>
</section>

<section class="py-14 px-6 bg-white">
    <div class="max-w-6xl mx-auto">

        @if ($galeris->count())
            @php
                $n = $galeris->count();
                $B = 'md:col-span-2 md:row-span-2'; $T = 'md:row-span-2'; $W2 = 'md:col-span-2'; $W3 = 'md:col-span-3'; $F = 'md:col-span-4 md:row-span-2';
                $pola = [
                    1 => [$F],
                    2 => [$B, $B],
                    3 => [$B, $T, $T],
                    4 => [$B, $T, '', ''],
                    5 => [$B, '', '', '', ''],
                    6 => [$B, '', '', '', $T, $W3],
                    7 => [$B, '', '', '', $T, $W2, ''],
                    8 => [$B, '', '', '', $T, '', '', ''],
                ][$n] ?? [];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 auto-rows-[140px] md:auto-rows-[160px] [grid-auto-flow:dense]">
                @foreach ($galeris as $i => $k)
                    @php
                        $foto = !empty($k->foto) ? [Storage::url($k->foto)] : [];
                        $cover = $foto[0] ?? null;
                        $span = ($pola[$i] ?? '') . (($i === 0 && $n % 2 === 1) ? ' col-span-2' : '');
                        $besar = $i === 0 && $n > 1;
                        $tgl = $k->created_at?->locale('id')->translatedFormat('d M Y');
                    @endphp
                    <div data-fade-in
                         class="opacity-0 translate-y-8 transition duration-700 gallery-card {{ $span }} group"
                         style="transition-delay: {{ ($i % 4) * 80 }}ms"
                         role="button" tabindex="0"
                         data-photos='@json($foto)'
                         data-title="{{ $k->judul }}"
                         data-date="{{ $tgl }}"
                         data-desc="{{ $k->deskripsi }}">
                        @if ($cover)
                            <img src="{{ $cover }}" alt="{{ $k->judul }}" loading="lazy" decoding="async">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-brand-700 to-brand-900"></div>
                        @endif
                        <div class="gallery-overlay"></div>
                        <div class="gallery-content">
                            @if ($tgl)
                                <span class="gallery-badge">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $tgl }}
                                </span>
                            @endif
                            <h3 class="text-white font-bold {{ $besar ? 'text-base md:text-lg' : 'text-sm md:text-base' }} leading-tight">{{ $k->judul }}</h3>
                            @if ($besar && $k->deskripsi)
                                <p class="text-white/70 text-xs mt-1 hidden md:block">{{ \Illuminate\Support\Str::limit($k->deskripsi, 70) }}</p>
                            @endif
                            @if (count($foto) > 1)
                                <span class="absolute top-[-2.6rem] right-4 text-[11px] font-semibold text-white bg-black/40 backdrop-blur px-2 py-1 rounded-full">{{ count($foto) }} foto</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $galeris->links() }}
            </div>
        @else
            <div class="text-center py-20 text-slate-500">
                <p class="font-semibold text-slate-700">Belum ada kegiatan.</p>
                <p class="text-sm mt-1">Dokumentasi kegiatan akan tampil di sini.</p>
            </div>
        @endif
    </div>
</section>

{{-- LIGHTBOX --}}
<div class="gal-lightbox" id="kg-lightbox" aria-hidden="true">
    <button type="button" id="kg-close" aria-label="Tutup"
            class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <button type="button" id="kg-prev" aria-label="Sebelumnya"
            class="hidden absolute left-3 md:left-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 border border-white/20 text-white items-center justify-center hover:bg-white/20 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button type="button" id="kg-next" aria-label="Berikutnya"
            class="hidden absolute right-3 md:right-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 border border-white/20 text-white items-center justify-center hover:bg-white/20 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>
    <img id="kg-img" src="" alt="">
    <div class="absolute bottom-6 left-0 right-0 text-center text-white px-6">
        <div id="kg-title" class="font-bold text-lg"></div>
        <div id="kg-meta" class="text-sm text-white/60 mt-1"></div>
        <div id="kg-desc" class="text-sm text-white/70 mt-1 max-w-xl mx-auto"></div>
    </div>
</div>

<script>
(function () {
    const box = document.getElementById('kg-lightbox');
    const img = document.getElementById('kg-img');
    const prev = document.getElementById('kg-prev');
    const next = document.getElementById('kg-next');
    let photos = [], idx = 0;

    function show() {
        img.src = photos[idx];
        const multi = photos.length > 1;
        prev.classList.toggle('hidden', !multi); prev.classList.toggle('flex', multi);
        next.classList.toggle('hidden', !multi); next.classList.toggle('flex', multi);
    }
    function open(card) {
        try { photos = JSON.parse(card.dataset.photos || '[]'); } catch (e) { photos = []; }
        if (!photos.length) return;
        idx = 0;
        document.getElementById('kg-title').textContent = card.dataset.title || '';
        document.getElementById('kg-meta').textContent = [card.dataset.kategori, card.dataset.date].filter(Boolean).join(' · ');
        document.getElementById('kg-desc').textContent = card.dataset.desc || '';
        show();
        box.classList.add('open');
        box.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
    function close() {
        box.classList.remove('open');
        box.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
    function go(d) { idx = (idx + d + photos.length) % photos.length; show(); }

    document.querySelectorAll('.gallery-card[data-photos]').forEach(card => {
        card.addEventListener('click', () => open(card));
        card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(card); } });
    });
    document.getElementById('kg-close').addEventListener('click', close);
    prev.addEventListener('click', e => { e.stopPropagation(); go(-1); });
    next.addEventListener('click', e => { e.stopPropagation(); go(1); });
    box.addEventListener('click', e => { if (e.target === box) close(); });
    img.addEventListener('click', e => e.stopPropagation());
    document.addEventListener('keydown', e => {
        if (!box.classList.contains('open')) return;
        if (e.key === 'Escape') close();
        if (photos.length > 1 && e.key === 'ArrowLeft') go(-1);
        if (photos.length > 1 && e.key === 'ArrowRight') go(1);
    });
})();
</script>
@endsection