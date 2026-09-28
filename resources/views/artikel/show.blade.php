@extends('layouts.app')

@section('title', $artikel->judul)

@section('content')

    <div class="pt-24">
        <div class="w-full h-[45vh] bg-blue-200"></div>
    </div>

    <div class="max-w-3xl mx-auto px-6 -mt-16 relative">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <span class="text-xs font-semibold text-blue-600 uppercase">{{ $artikel->kategori }}</span>
            <h1 class="text-3xl font-extrabold text-blue-950 mt-2 mb-4">
                {{ $artikel->judul }}
            </h1>
            <div class="text-sm text-slate-400 mb-8">{{ $artikel->published_at?->format('d F Y') }}</div>

            <div class="prose prose-blue max-w-none text-slate-700">
                {!! $artikel->konten !!}
            </div>

            <div class="flex items-center gap-3 mt-10 pt-6 border-t border-blue-100">
                <span class="text-sm text-slate-500">Bagikan:</span>
                <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . url()->current()) }}" target="_blank" class="text-sm bg-green-50 text-green-700 px-4 py-2 rounded-full hover:bg-green-100">WhatsApp</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="text-sm bg-blue-50 text-blue-700 px-4 py-2 rounded-full hover:bg-blue-100">Facebook</a>
                <button onclick="navigator.clipboard.writeText(window.location.href)" class="text-sm bg-slate-50 text-slate-700 px-4 py-2 rounded-full hover:bg-slate-100">Salin Link</button>
            </div>
        </div>

        <div class="mt-16 mb-20">
            <h2 class="text-xl font-bold text-blue-950 mb-6">Artikel Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($terkait as $item)
                    <a href="{{ route('artikel.show', $item->slug) }}" class="block bg-white border border-blue-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="w-full aspect-video bg-blue-100"></div>
                        <div class="p-4">
                            <h3 class="font-semibold text-blue-950 text-sm">{{ $item->judul }}</h3>
                        </div>
                    </a>
                @empty
                    <p class="text-slate-400 text-sm col-span-3">Belum ada artikel terkait.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection