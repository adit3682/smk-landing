@extends('layouts.app')

@section('title', 'Fasilitas - ' . ($profilSekolah->nama_sekolah ?? 'SMK'))

@section('content')
<div class="pt-32 pb-20 px-6 max-w-6xl mx-auto">

    <div class="text-center mb-12">
        <h1 class="font-serif text-4xl font-bold text-amber-500">Fasilitas</h1>
        <p class="mt-3 text-slate-600 max-w-2xl mx-auto">
            Sarana dan prasarana yang mendukung kegiatan belajar mengajar di
            <strong class="text-slate-900">{{ $profilSekolah->nama_sekolah ?? 'sekolah kami' }}</strong>.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($sarpras as $item)
            <div data-fade-in class="opacity-0 translate-y-8 transition duration-700">
                <div class="overflow-hidden rounded-2xl bg-slate-200 aspect-[4/3]">
                    @if (!empty($item->foto))
                        <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}" loading="lazy"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-blue-100"></div>
                    @endif
                </div>
                <h2 class="mt-4 font-serif text-xl font-semibold text-slate-900">{{ $item->nama }}</h2>
                @if (!empty($item->deskripsi))
                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ $item->deskripsi }}</p>
                @endif
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