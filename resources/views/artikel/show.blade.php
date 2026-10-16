@extends('layouts.app')

@section('title', $artikel->judul)

@section('content')
@php
    $gambar = $artikel->gambar ?? $artikel->thumbnail ?? $artikel->foto ?? null;
@endphp

{{-- HERO: foto artikel (jika ada) atau gradasi brand --}}
<section class="relative h-[48vh] min-h-[320px] overflow-hidden grain">
    @if($gambar)
        <img src="{{ asset('storage/' . $gambar) }}" alt="{{ $artikel->judul }}"
             fetchpriority="high" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/80 via-brand-950/30 to-brand-950/40"></div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800"></div>
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 20%, rgba(89,166,255,.4) 0%, transparent 50%);"></div>
    @endif
</section>

<div class="max-w-3xl mx-auto px-6 -mt-24 relative z-10">
    <article class="bg-white rounded-3xl shadow-card border border-slate-100 p-6 md:p-10">

        <nav class="flex flex-wrap items-center gap-2 text-sm text-slate-400 mb-5" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition">Beranda</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('artikel.index') }}" class="hover:text-brand-600 transition">Artikel &amp; Berita</a>
        </nav>

        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-brand-700 bg-brand-50 rounded-full px-3 py-1 uppercase tracking-wide">{{ $artikel->kategori }}</span>
            <span class="text-sm text-slate-400">{{ $artikel->published_at?->translatedFormat('d F Y') }}</span>
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold text-brand-950 tracking-tight leading-tight mt-4 mb-8">
            {{ $artikel->judul }}
        </h1>

        <div class="artikel-konten max-w-none">
            {!! $artikel->konten !!}
        </div>

        <div class="flex flex-wrap items-center gap-3 mt-10 pt-6 border-t border-slate-100">
            <span class="text-sm font-semibold text-slate-500">Bagikan:</span>
            <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . url()->current()) }}" target="_blank" rel="noopener"
               class="text-sm font-semibold bg-emerald-50 text-emerald-700 px-4 py-2 rounded-full hover:bg-emerald-100 transition">WhatsApp</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
               class="text-sm font-semibold bg-brand-50 text-brand-700 px-4 py-2 rounded-full hover:bg-brand-100 transition">Facebook</a>
            <button type="button" id="salin-link"
                    class="text-sm font-semibold bg-slate-100 text-slate-700 px-4 py-2 rounded-full hover:bg-slate-200 transition">Salin Link</button>
        </div>
    </article>

    {{-- ARTIKEL TERKAIT --}}
    <div class="mt-16 mb-24">
        <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Baca Juga</p>
        <h2 class="text-2xl font-extrabold text-brand-950 tracking-tight mb-6">Artikel Terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($terkait as $item)
                @php
                    $gambarItem = $item->gambar ?? $item->thumbnail ?? $item->foto ?? null;
                @endphp
                <a href="{{ route('artikel.show', $item->slug) }}"
                   class="card-lift group block bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                    <div class="w-full aspect-video bg-brand-50 overflow-hidden">
                        @if($gambarItem)
                            <img src="{{ asset('storage/' . $gambarItem) }}" alt="{{ $item->judul }}"
                                 loading="lazy" decoding="async"
                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-brand-800 to-brand-600"></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-brand-950 text-sm leading-snug line-clamp-2 group-hover:text-brand-600 transition">{{ $item->judul }}</h3>
                    </div>
                </a>
            @empty
                <p class="text-slate-400 text-sm col-span-full">Belum ada artikel terkait.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    (function () {
        const btn = document.getElementById('salin-link');
        if (!btn) return;
        btn.addEventListener('click', function () {
            const awal = btn.textContent;
            const selesai = () => { btn.textContent = 'Tersalin!'; setTimeout(() => btn.textContent = awal, 1800); };
            if (navigator.clipboard) {
                navigator.clipboard.writeText(window.location.href).then(selesai);
            }
        });
    })();
</script>
@endsection