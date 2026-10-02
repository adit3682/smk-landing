<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SMK Teknologi Informasi')</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

</head>

<body class="font-sans text-slate-800 bg-white antialiased">

{{-- Navbar pill mengambang, sesuai PRD 6.2 --}}
<header class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[92%] max-w-4xl">
    <nav class="flex items-center justify-between gap-4 bg-white/70 backdrop-blur-md rounded-full px-6 py-3 shadow-lg">

        <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-blue-900 text-lg">
            @if($navProfil?->logo)
                <img src="{{ Storage::url($navProfil->logo) }}" alt="Logo" class="h-8 w-auto">
            @else
                SMK TI
            @endif
        </a>

        <div class="hidden md:flex items-center gap-6 text-sm font-medium text-blue-950">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
            <a href="{{ route('profil-sekolah') }}" class="hover:text-blue-600">Profil Sekolah</a>
            <a href="{{ route('artikel.index') }}" class="hover:text-blue-600">Artikel</a>
            <a href="{{ route('transparansi') }}" class="hover:text-blue-600">Transparansi</a>
            <a href="#kontak" class="hover:text-blue-600">Kontak</a>
        </div>

        <a href="{{ route('spmb') }}" class="bg-blue-900 text-white text-sm font-semibold px-5 py-2 rounded-full hover:bg-blue-800 transition">
            SPMB 
        </a>

    </nav>
</header>

<main>
    @yield('content')
</main>

<footer class="bg-slate-950 text-slate-300">

    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 lg:gap-16">

            {{-- MENU --}}
            <div class="space-y-3">
                <a href="{{ route('home') }}" class="block text-sm font-medium hover:text-white transition">Beranda</a>
                <a href="{{ route('profil-sekolah') }}" class="block text-sm font-medium hover:text-white transition">Profil Sekolah</a>
                <a href="{{ route('artikel.index') }}" class="block text-sm font-medium hover:text-white transition">Artikel</a>
                <a href="{{ route('transparansi') }}" class="block text-sm font-medium hover:text-white transition">Transparansi</a>
                <a href="#kontak" class="block text-sm font-medium hover:text-white transition">Kontak</a>
                <a href="{{ route('spmb') }}" class="block text-sm font-medium hover:text-white transition">SPMB</a> 
            </div>

            {{-- LEGAL --}}
            <div class="space-y-3">
                <a href="#" class="block text-sm font-medium hover:text-white transition">Kebijakan Privasi</a>
                <a href="#" class="block text-sm font-medium hover:text-white transition">Syarat &amp; Ketentuan</a>
            </div>

            {{-- IKUTI KAMI --}}

        <div>
            <h4 class="text-white font-semibold mb-2">Ikuti Kami</h4>

        <p class="text-slate-400 text-sm mb-5">
            {{ $navProfil->nama_sekolah ?? 'SMK TI Bina Citra Informatika' }}
        </p>

        <div class="flex gap-3">
    @if($navProfil?->instagram)
        <a href="{{ $navProfil->instagram }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-slate-700 transition">
            <span class="text-xs font-bold">ig</span>
        </a>
    @endif
    @if($navProfil?->tiktok)
        <a href="{{ $navProfil->tiktok }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center hover:bg-slate-700 transition">
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

            <a href="https://wa.me/{{ $whatsapp }}"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 mt-4 text-sm text-slate-400 hover:text-white transition">
                <span class="font-medium">WhatsApp</span>
                <span>{{ $navProfil->spmb_whatsapp }}</span>
            </a>
        @endif

</div>


        </div>

        {{-- SPONSOR & MITRA --}}
        @if($sponsors->count() > 0)
            <div class="border-t border-slate-800 mt-12 pt-8">
                <p class="text-slate-500 text-xs uppercase tracking-wider text-center mb-6">Didukung Oleh</p>
                <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-6">
                    @foreach($sponsors as $sponsor)
                        @if($sponsor->url)
                            <a href="{{ $sponsor->url }}" target="_blank" class="opacity-70 hover:opacity-100 transition">
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
        }, {
            threshold: 0.15
        });

        items.forEach(el => observer.observe(el));
    });
</script>

</body>

</html>
