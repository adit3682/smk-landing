@extends('layouts.app')

@section('title', 'Artikel & Berita')

@section('content')
<div class="pt-32 pb-20 px-6 max-w-6xl mx-auto">

    <h1 class="text-4xl font-extrabold text-blue-950 mb-8 text-center">Artikel & Berita</h1>

    <form method="GET" action="{{ route('artikel.index') }}" class="mb-10">
        <div class="flex flex-wrap justify-center gap-2 mb-6">
            @foreach(['semua' => 'Semua', 'prestasi' => 'Prestasi', 'kegiatan' => 'Kegiatan', 'pengumuman' => 'Pengumuman', 'berita' => 'Berita'] as $key => $label)
                <button
                    type="submit"
                    name="kategori"
                    value="{{ $key }}"
                    class="px-4 py-2 rounded-full text-sm font-medium transition {{ (request('kategori', 'semua') === $key) ? 'bg-blue-900 text-white' : 'bg-blue-50 text-blue-900 hover:bg-blue-100' }}"
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
                class="w-full px-5 py-3 rounded-full border border-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-300"
            >
            <input type="hidden" name="kategori" value="{{ request('kategori', 'semua') }}">
            <button type="submit" class="bg-blue-900 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-800 transition whitespace-nowrap">
                Cari
            </button>
        </div>
    </form>

    @if(request('search') || (request('kategori') && request('kategori') !== 'semua'))
        <div class="text-center text-sm text-slate-500 mb-6">
            Menampilkan {{ $artikels->total() }} hasil
            @if(request('search')) untuk "<strong>{{ request('search') }}</strong>" @endif
            <a href="{{ route('artikel.index') }}" class="text-blue-700 hover:underline ml-2">Reset filter</a>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($artikels as $artikel)
            <a href="{{ route('artikel.show', $artikel->slug) }}" class="block bg-white border border-blue-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="w-full aspect-video bg-blue-100 overflow-hidden">
                    <div class="w-full h-full bg-blue-100 group-hover:scale-105 transition duration-300"></div>
                </div>
                <div class="p-5">
                    <span class="text-xs font-semibold text-blue-600 uppercase">{{ $artikel->kategori }}</span>
                    <h3 class="font-semibold text-blue-950 mt-1">{{ $artikel->judul }}</h3>
                    <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ $artikel->excerpt }}</p>
                    <div class="text-xs text-slate-400 mt-3">{{ $artikel->published_at?->format('d M Y') }}</div>
                </div>
            </a>
        @empty
            <p class="text-slate-400 text-sm col-span-3 text-center">Tidak ada artikel yang cocok.</p>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $artikels->links() }}
    </div>

</div>
@endsection