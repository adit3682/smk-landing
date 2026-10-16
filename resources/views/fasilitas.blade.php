@extends('layouts.app')

@section('title', 'Fasilitas - ' . ($profilSekolah->nama_sekolah ?? 'SMK'))

@section('content')

{{-- HEADER HALAMAN --}}
<section class="relative pt-32 pb-16 px-6 text-white overflow-hidden grain">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800"></div>
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 20%, rgba(89,166,255,.4) 0%, transparent 50%);"></div>
    <div class="relative z-10 max-w-3xl mx-auto text-center">
        <p class="text-brand-200 font-semibold text-sm tracking-wide uppercase mb-3">Sarana &amp; Prasarana</p>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight"><span class="text-gradient">Fasilitas</span></h1>
        <p class="text-brand-200/80 mt-4 leading-relaxed">
            Sarana dan prasarana yang mendukung kegiatan belajar mengajar di
            <strong class="text-white">{{ $profilSekolah->nama_sekolah ?? 'sekolah kami' }}</strong>.
        </p>
    </div>
</section>

<div class="py-16 px-6 max-w-6xl mx-auto">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
        @forelse ($sarpras as $item)
            <div data-fade-in class="opacity-0 translate-y-8 transition duration-700">
                <div class="card-lift group bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm h-full">
                    <div class="overflow-hidden bg-brand-50 aspect-[4/3]">
                        @if (!empty($item->foto))
                            <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}"
                                 loading="lazy" decoding="async"
                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-brand-800 to-brand-600"></div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h2 class="text-lg font-bold text-brand-950">{{ $item->nama }}</h2>
                        @if (!empty($item->deskripsi))
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-slate-400 text-sm col-span-full text-center">Belum ada data fasilitas.</p>
        @endforelse
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-fade-in]').forEach(el => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        el.classList.remove('opacity-0', 'translate-y-8');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            observer.observe(el);
        });
    });
</script>
@endsection