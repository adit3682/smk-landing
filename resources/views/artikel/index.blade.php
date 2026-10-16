@extends('layouts.app')

@section('title', 'Artikel & Berita')

@section('content')

{{-- HEADER HALAMAN --}}
<section class="relative pt-32 pb-16 px-6 text-white overflow-hidden grain">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800"></div>
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 20%, rgba(89,166,255,.4) 0%, transparent 50%);"></div>
    <div class="relative z-10 max-w-3xl mx-auto text-center">
        <p class="text-brand-200 font-semibold text-sm tracking-wide uppercase mb-3">Kabar Terbaru</p>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight"><span class="text-gradient">Artikel &amp; Berita</span></h1>
        <p class="text-brand-200/80 mt-4">Prestasi, kegiatan, dan pengumuman dari sekolah kami.</p>
    </div>
</section>

<div class="py-14 px-6 max-w-6xl mx-auto">

    <form method="GET" action="{{ route('artikel.index') }}" class="mb-10">
        <div class="flex flex-wrap justify-center gap-2 mb-6">
            @foreach(['semua' => 'Semua', 'prestasi' => 'Prestasi', 'kegiatan' => 'Kegiatan', 'pengumuman' => 'Pengumuman', 'berita' => 'Berita'] as $key => $label)
                <button
                    type="submit"
                    name="kategori"
                    value="{{ $key }}"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition {{ (request('kategori', 'semua') === $key) ? 'bg-brand-600 text-white shadow-glow' : 'bg-white border border-slate-200 text-slate-600 hover:border-brand-300 hover:text-brand-700' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="max-w-md mx-auto flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari artikel..."
                class="w-full px-5 py-3 rounded-full bg-white border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300"
            >
            <input type="hidden" name="kategori" value="{{ request('kategori', 'semua') }}">
            <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-brand-700 transition whitespace-nowrap">
                Cari
            </button>
        </div>
    </form>

    @if(request('search') || (request('kategori') && request('kategori') !== 'semua'))
        <div class="text-center text-sm text-slate-500 mb-8">
            Menampilkan {{ $artikels->total() }} hasil
            @if(request('search')) untuk "<strong class="text-brand-950">{{ request('search') }}</strong>" @endif
            <a href="{{ route('artikel.index') }}" class="text-brand-600 font-semibold hover:underline ml-2">Reset filter</a>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
        @forelse($artikels as $artikel)
            @php
                $gambar = $artikel->gambar ?? $artikel->thumbnail ?? $artikel->foto ?? null;
            @endphp
            <a href="{{ route('artikel.show', $artikel->slug) }}"
               class="card-lift group flex flex-col bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                <div class="w-full aspect-video bg-brand-50 overflow-hidden">
                    @if($gambar)
                        <img src="{{ asset('storage/' . $gambar) }}" alt="{{ $artikel->judul }}"
                             loading="lazy" decoding="async"
                             class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-brand-800 to-brand-600 group-hover:scale-105 transition duration-500"></div>
                    @endif
                </div>
                <div class="flex flex-col flex-1 p-5">
                    <div class="flex items-center gap-2 text-xs">
                        <span class="font-semibold text-brand-700 bg-brand-50 rounded-full px-2.5 py-1 uppercase tracking-wide">{{ $artikel->kategori }}</span>
                        <span class="text-slate-400">{{ $artikel->published_at?->format('d M Y') }}</span>
                    </div>
                    <h3 class="font-bold text-brand-950 mt-3 leading-snug line-clamp-2 group-hover:text-brand-600 transition">{{ $artikel->judul }}</h3>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed line-clamp-2">{{ $artikel->excerpt }}</p>
                    <span class="mt-auto pt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-600 group-hover:gap-2 transition-all">
                        Baca selengkapnya <span aria-hidden="true">&rarr;</span>
                    </span>
                </div>
            </a>
        @empty
            <p class="text-slate-400 text-sm col-span-full text-center">Tidak ada artikel yang cocok.</p>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $artikels->links() }}
    </div>

</div>
@endsection