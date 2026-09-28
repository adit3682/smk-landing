@extends('layouts.app')

@section('title', 'Transparansi Penggunaan Dana')

@section('content')
<div class="pt-32 pb-20 px-6 max-w-5xl mx-auto">

    <h1 class="text-4xl font-extrabold text-blue-950 mb-3 text-center">Transparansi Penggunaan Dana</h1>
    <p class="text-slate-600 text-center max-w-2xl mx-auto mb-12">
        Laporan realisasi penggunaan dana sekolah yang dipublikasikan secara berkala sebagai bentuk akuntabilitas kepada masyarakat.
    </p>

    @forelse($laporans as $laporan)
        <section data-fade-in class="mb-12 opacity-0 translate-y-8 transition duration-700">
            <div class="bg-white border border-blue-100 rounded-2xl overflow-hidden shadow-sm">

                {{-- Header laporan --}}
                <div class="bg-blue-50 px-6 py-5 border-b border-blue-100">
                    <h2 class="text-lg font-bold text-blue-950">{{ $laporan->judul }}</h2>
                    <div class="flex flex-wrap gap-x-6 gap-y-1 mt-2 text-sm text-slate-600">
                        @if($laporan->periode)
                            <span>Periode: <strong>{{ $laporan->periode }}</strong></span>
                        @endif
                        @if($laporan->tahap)
                            <span>{{ $laporan->tahap }}</span>
                        @endif
                        @if($laporan->sumber_dana)
                            <span>Sumber: <strong>{{ $laporan->sumber_dana }}</strong></span>
                        @endif
                        <span>Tahun {{ $laporan->tahun }}</span>
                    </div>
                </div>

                {{-- Gambar laporan --}}
                @if($laporan->gambar)
                    <div class="p-4 bg-slate-50">
                        <a href="{{ Storage::url($laporan->gambar) }}" target="_blank" class="block group relative">
                            <img src="{{ Storage::url($laporan->gambar) }}"
                                 alt="{{ $laporan->judul }}"
                                 class="w-full rounded-xl border border-slate-200 group-hover:opacity-90 transition">
                            <span class="absolute bottom-3 right-3 bg-blue-900/90 text-white text-xs px-3 py-1.5 rounded-full opacity-0 group-hover:opacity-100 transition">
                                Klik untuk perbesar
                            </span>
                        </a>
                    </div>
                @endif

                {{-- Keterangan & tombol --}}
                <div class="px-6 py-5">
                    @if($laporan->keterangan)
                        <p class="text-sm text-slate-600 mb-4">{{ $laporan->keterangan }}</p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        @if($laporan->file_pdf)
                            <a href="{{ Storage::url($laporan->file_pdf) }}"
                               download
                               class="inline-flex items-center gap-2 bg-blue-900 text-white text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-blue-800 transition">
                                Unduh PDF
                            </a>
                        @endif

                        @if($laporan->gambar)
                            <a href="{{ Storage::url($laporan->gambar) }}"
                               download
                               class="inline-flex items-center gap-2 bg-blue-50 text-blue-900 text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-blue-100 transition">
                                Unduh Gambar
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </section>
   @empty
    <div class="text-center py-12">
        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-2xl">📄</span>
        </div>
        <p class="text-slate-500 font-medium">Belum tersedia</p>
        <p class="text-slate-400 text-sm mt-1">Laporan transparansi akan segera dipublikasikan di sini.</p>
    </div>
@endforelse

</div>
@endsection