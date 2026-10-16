<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SMK Teknologi Informasi')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
</head>

<body class="font-sans text-slate-800 bg-white antialiased">

{{-- TOP BAR KONTAK --}}
@if($navProfil?->telepon || $navProfil?->email)
    <div class="bg-blue-950 text-blue-100 text-xs">
        <div class="max-w-7xl mx-auto px-6 py-2 flex flex-wrap items-center justify-center sm:justify-between gap-2">
            <div class="flex flex-wrap items-center gap-4">
                @if($navProfil->telepon)
                    <a href="tel:{{ preg_replace('/\s+/', '', $navProfil->telepon) }}" class="hover:text-white transition">
                        {{ $navProfil->telepon }}
                    </a>
                @endif
                @if($navProfil->email)
                    <a href="mailto:{{ $navProfil->email }}" class="hover:text-white transition">
                        {{ $navProfil->email }}
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif

{{-- NAVBAR --}}
@php
    $menu = [
        ['Beranda', 'home'],
        ['Profil Sekolah', 'profil-sekolah'],
        ['Fasilitas', 'fasilitas'],
        ['Artikel', 'artikel.index'],
        ['Transparansi', 'transparansi'],
        ['Kontak', 'kontak'],
    ];
@endphp

<header x-data="{ open: false }" class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-5xl">
    <nav class="nav-glass flex items-center justify-between gap-4 rounded-2xl px-5 py-3 shadow-lg shadow-brand-950/5">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-brand-950 text-lg">
            @if($navProfil?->logo)
                <img src="{{ Storage::url($navProfil->logo) }}" alt="Logo" class="h-8 w-auto">
            @else
                SMK TI
            @endif
        </a>

        <div class="hidden md:flex items-center gap-1 text-[13.5px] font-medium text-slate-700">
            @foreach($menu as [$label, $route])
                <a href="{{ route($route) }}"
                   class="px-3.5 py-1.5 rounded-lg transition hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs($route) ? 'bg-brand-50 text-brand-700' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('spmb') }}"
               class="bg-brand-600 hover:bg-brand-700 text-white text-[13px] font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-brand-600/25 transition active:scale-[0.97]">
                Daftar SPMB
            </a>

            <button type="button" @click="open = !open" class="md:hidden p-2 rounded-lg text-brand-950 hover:bg-brand-50" aria-label="Menu" :aria-expanded="open.toString()">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" style="display:none" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>
    </nav>

    {{-- Menu HP --}}
    <div x-show="open" x-transition @click.outside="open = false" @keydown.escape.window="open = false" style="display:none"
         class="md:hidden nav-glass mt-2 rounded-2xl p-3 shadow-lg">
        @foreach($menu as [$label, $route])
            <a href="{{ route($route) }}" @click="open = false"
               class="block px-4 py-3 rounded-xl text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-700 {{ request()->routeIs($route) ? 'bg-brand-50 text-brand-700' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="bg-brand-950 text-slate-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 lg:gap-16">

            {{-- MENU --}}
            <div class="space-y-3">
                <a href="{{ route('home') }}" class="block text-sm font-medium hover:text-white transition">Beranda</a>
                <a href="{{ route('profil-sekolah') }}" class="block text-sm font-medium hover:text-white transition">Profil Sekolah</a>
                <a href="{{ route('fasilitas') }}" class="block text-sm font-medium hover:text-white transition">Fasilitas</a>
                <a href="{{ route('artikel.index') }}" class="block text-sm font-medium hover:text-white transition">Artikel</a>
                <a href="{{ route('transparansi') }}" class="block text-sm font-medium hover:text-white transition">Transparansi</a>
                <a href="{{ route('kontak') }}" class="block text-sm font-medium hover:text-white transition">Kontak</a>
                <a href="{{ route('spmb') }}" class="block text-sm font-medium hover:text-white transition">SPMB</a>
            </div>

                       {{-- PROGRAM KEAHLIAN --}}
            @php
                $footerJurusans = \App\Models\Jurusan::orderBy('nama')->get(['nama', 'slug']);
            @endphp
            <div class="space-y-3">
                @foreach($footerJurusans as $j)
                    <a href="{{ route('jurusan.show', $j->slug) }}" class="block text-sm font-medium hover:text-white transition">{{ $j->nama }}</a>
                @endforeach
            </div>

            {{-- IKUTI KAMI --}}
            <div>
                <h4 class="text-white font-semibold mb-2">Ikuti Kami</h4>
                <p class="text-slate-400 text-sm mb-5">
                    {{ $navProfil->nama_sekolah ?? 'SMK TI Bina Citra Informatika' }}
                </p>

                <div class="flex gap-3">
                    @if($navProfil?->instagram)
                        <a href="{{ $navProfil->instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram sekolah" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-slate-700 transition">
                            <span class="text-xs font-bold">ig</span>
                        </a>
                    @endif
                    @if($navProfil?->tiktok)
                        <a href="{{ $navProfil->tiktok }}" target="_blank" rel="noopener noreferrer" aria-label="TikTok sekolah" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-slate-700 transition">
                            <span class="text-xs font-bold">tt</span>
                        </a>
                    @endif
                </div>

                {{-- WHATSAPP --}}
                @if($navProfil?->spmb_whatsapp)
                    @php
                        $whatsapp = preg_replace('/[^0-9]/', '', $navProfil->spmb_whatsapp);
                        if (str_starts_with($whatsapp, '0')) {
                            $whatsapp = '62' . substr($whatsapp, 1);
                        }
                    @endphp

                    <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 mt-4 text-sm text-slate-400 hover:text-white transition">
                        <span class="font-medium">WhatsApp</span>
                        <span>{{ $navProfil->spmb_whatsapp }}</span>
                    </a>
                @endif
            </div>
        </div>

        {{-- SPONSOR & MITRA --}}
        @if(isset($sponsors) && $sponsors->count() > 0)
            <div class="border-t border-slate-800 mt-12 pt-8">
                <p class="text-slate-500 text-xs uppercase tracking-wider text-center mb-6">Mitra Kami</p>
                <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-6">
                    @foreach($sponsors as $sponsor)
                        @if($sponsor->url)
                            <a href="{{ $sponsor->url }}" target="_blank" rel="noopener noreferrer" class="opacity-70 hover:opacity-100 transition">
                        @else
                            <span class="opacity-70">
                        @endif
                            <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->nama }}" class="h-10 w-auto object-contain">
                        @if($sponsor->url)
                            </a>
                        @else
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- GARIS PEMISAH & COPYRIGHT --}}
        <div class="border-t border-slate-800 mt-12 pt-6 text-center">
            <p class="text-slate-500 text-xs">
                {{ $navProfil->nama_sekolah ?? 'SMK TI Bina Citra Informatika Purwokerto' }}, {{ date('Y') }} ALL RIGHTS RESERVED.
            </p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('[data-fade-in]');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-8');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        items.forEach(el => observer.observe(el));
    });
</script>

</body>
</html>
