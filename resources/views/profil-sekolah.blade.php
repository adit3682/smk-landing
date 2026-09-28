@extends('layouts.app')

@section('title', 'Profil Sekolah Lengkap')

@section('content')
<div class="pt-32 pb-20 px-6 max-w-5xl mx-auto">

    <h1 class="text-4xl font-extrabold text-blue-950 mb-10 text-center">Profil Sekolah</h1>

    {{-- DATA UMUM --}}
    <section data-fade-in class="mb-16 opacity-0 translate-y-8 transition duration-700">
        <h2 class="text-2xl font-bold text-blue-900 mb-4">Data Umum</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-blue-50 rounded-2xl p-6">
            <div><span class="text-sm text-slate-500">Nama Sekolah</span><div class="font-semibold text-blue-950">{{ $profilSekolah->nama_sekolah ?? '-' }}</div></div>
            <div><span class="text-sm text-slate-500">NPSN</span><div class="font-semibold text-blue-950">{{ $profilSekolah->npsn ?? '-' }}</div></div>
            <div><span class="text-sm text-slate-500">Alamat</span><div class="font-semibold text-blue-950">{{ $profilSekolah->alamat ?? '-' }}</div></div>
            <div><span class="text-sm text-slate-500">Kepala Sekolah</span><div class="font-semibold text-blue-950">{{ $profilSekolah->nama_kepala_sekolah ?? '-' }}</div></div>
        </div>
    </section>

    {{-- VISI MISI --}}
    <section data-fade-in class="mb-16 opacity-0 translate-y-8 transition duration-700">
        <h2 class="text-2xl font-bold text-blue-900 mb-4">Visi & Misi</h2>
        <p class="text-slate-600 mb-4">{{ $profilSekolah->visi ?? '-' }}</p>
        <ul class="list-disc list-inside text-slate-600 space-y-1">
            @forelse(($profilSekolah->misi ?? []) as $poin)
                <li>{{ $poin }}</li>
            @empty
                <li>Belum ada data misi.</li>
            @endforelse
        </ul>
    </section>

    {{-- GRAFIK TREN SISWA --}}
    <section data-fade-in class="mb-16 opacity-0 translate-y-8 transition duration-700">
        <h2 class="text-2xl font-bold text-blue-900 mb-4">Tren Jumlah Siswa</h2>
        <div class="bg-white border border-blue-100 rounded-2xl p-6">
            <canvas id="chartSiswa" height="100"></canvas>
        </div>
    </section>

    {{-- STAF TU --}}
    <section data-fade-in class="mb-16 opacity-0 translate-y-8 transition duration-700">
        <h2 class="text-2xl font-bold text-blue-900 mb-4">Staf Tata Usaha</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($stafs as $staf)
                <div class="text-center">
                    @if(!empty($staf->foto))
                        <img src="{{ Storage::url($staf->foto) }}" alt="{{ $staf->nama }}" class="w-full aspect-square object-cover rounded-xl mb-2">
                    @else
                        <div class="w-full aspect-square bg-blue-100 rounded-xl mb-2 flex items-center justify-center text-blue-400 font-bold text-xl">
                            {{ substr($staf->nama, 0, 1) }}
                        </div>
                    @endif
                    <div class="text-sm font-semibold text-blue-950">{{ $staf->nama }}</div>
                    <div class="text-xs text-slate-500">{{ $staf->jabatan }}</div>
                </div>
            @empty
                <p class="text-slate-400 text-sm col-span-4">Belum ada data staf.</p>
            @endforelse
        </div>
    </section>

    {{-- SARANA PRASARANA --}}
    <section data-fade-in class="mb-16 opacity-0 translate-y-8 transition duration-700">
        <h2 class="text-2xl font-bold text-blue-900 mb-4">Sarana & Prasarana</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($sarpras as $item)
                <div class="bg-white border border-blue-100 rounded-2xl overflow-hidden shadow-sm">
                    @if(!empty($item->foto))
                        <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}" class="w-full aspect-video object-cover">
                    @else
                        <div class="w-full aspect-video bg-blue-100"></div>
                    @endif
                    <div class="p-4">
                        <div class="font-semibold text-blue-950">{{ $item->nama }}</div>
                        <div class="text-sm text-slate-500 mt-1">{{ $item->deskripsi }}</div>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm col-span-3">Belum ada data sarpras.</p>
            @endforelse
        </div>
    </section>

    {{-- AKREDITASI --}}
    <section data-fade-in class="mb-16 opacity-0 translate-y-8 transition duration-700">
        <h2 class="text-2xl font-bold text-blue-900 mb-4">Akreditasi</h2>
        @if($akreditasi)
            <div class="inline-flex items-center gap-3 bg-blue-900 text-white px-6 py-4 rounded-2xl">
                <span class="text-3xl font-extrabold">{{ $akreditasi->peringkat }}</span>
                <div class="text-sm">
                    <div>{{ $akreditasi->lembaga_penerbit }}</div>
                    <div class="text-blue-200">Berlaku s.d. {{ $akreditasi->tahun_berlaku }}</div>
                </div>
            </div>
        @else
            <p class="text-slate-400 text-sm">Belum ada data akreditasi.</p>
        @endif
    </section>


<section data-fade-in class="mb-16 opacity-0 translate-y-8 transition duration-700">
    <h2 class="text-2xl font-bold text-blue-900 mb-8">Struktur Organisasi</h2>

    {{-- Desktop: tree dengan garis penghubung --}}
    <div class="hidden md:flex flex-col items-center">
        @if($struktur->count() > 0)
            {{-- Level 1: Kepala Sekolah (item pertama) --}}
            <div class="bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold shadow-sm">
                {{ $struktur->first()->jabatan }}
                <div class="text-xs font-normal text-blue-200 mt-0.5">{{ $struktur->first()->nama_pejabat }}</div>
            </div>

            @if($struktur->count() > 1)
                {{-- Garis vertikal turun dari Kepsek --}}
                <div class="w-px h-8 bg-blue-200"></div>

                {{-- Garis horizontal penghubung ke anak-anak --}}
                <div class="relative flex justify-center w-full max-w-2xl">
                    <div class="absolute top-0 h-px bg-blue-200" style="left: 12.5%; right: 12.5%;"></div>

                    <div class="flex justify-between w-full gap-4 pt-8">
                        @foreach($struktur->skip(1) as $s)
                            <div class="flex flex-col items-center relative flex-1">
                                <div class="absolute -top-8 w-px h-8 bg-blue-200"></div>
                                <div class="bg-blue-100 text-blue-950 px-4 py-2 rounded-xl text-center">
                                    <div class="font-medium text-sm">{{ $s->jabatan }}</div>
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

    {{-- Mobile: accordion (tetap seperti sebelumnya) --}}
    <div class="md:hidden space-y-2" x-data="{ open: null }">
        @foreach($struktur as $i => $s)
            <div class="border border-blue-100 rounded-xl overflow-hidden">
                <button @click="open = open === {{ $i }} ? null : {{ $i }}" class="w-full text-left px-4 py-3 font-medium text-blue-950 bg-blue-50">
                    {{ $s->jabatan }}
                </button>
                <div x-show="open === {{ $i }}" class="px-4 py-3 text-sm text-slate-600">
                    {{ $s->nama_pejabat }}
                </div>
            </div>
        @endforeach
    </div>
</section>

    {{-- PROFIL YAYASAN --}}
    <section data-fade-in class="opacity-0 translate-y-8 transition duration-700">
        <h2 class="text-2xl font-bold text-blue-900 mb-4">Profil Yayasan</h2>
        <p class="text-slate-600">{{ $profilSekolah->profil_yayasan ?? '-' }}</p>
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
                        borderColor: '#1e3a8a',
                        backgroundColor: 'rgba(30,58,138,0.1)',
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