@extends('layouts.app')

@section('title', 'Beranda - ' . ($profilSekolah->nama_sekolah ?? 'SMK Teknologi Informasi'))

@section('content')

    {{-- HERO --}}
    <section id="hero-section" class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 bg-blue-950 text-white overflow-hidden">
       <div class="absolute inset-0 bg-cover bg-center opacity-30"
     style="background-image: url('{{ $profilSekolah->foto_hero ? Storage::url($profilSekolah->foto_hero) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920' }}'); mask-image: linear-gradient(to bottom, black 60%, transparent 100%);">
        </div>
        <div class="relative z-10 max-w-3xl">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                Mencetak Talenta Digital<br>
                Masa Depan Indonesia
            </h1>
            <p class="text-blue-200 text-lg mb-8">
                {{ $profilSekolah->nama_sekolah ?? 'SMK Teknologi Informasi' }} — modern, profesional, dan siap kerja.
            </p>
            <a id="ppdb" href="{{ $linkPpdb ?? '#' }}" target="_blank" class="inline-block bg-white text-blue-900 font-semibold px-8 py-3 rounded-full hover:bg-blue-100 transition">
                Daftar Sekarang
            </a>
        </div>
    </section>

    {{-- PROFIL SINGKAT + COUNTER --}}
    <section class="relative z-10 bg-white rounded-t-[2.5rem] -mt-10 pt-20 pb-20 px-6">
        <div data-fade-in class="max-w-5xl mx-auto text-center opacity-0 translate-y-8 transition duration-700">
            <h2 class="text-3xl font-bold text-blue-950 mb-4">Tentang Sekolah Kami</h2>
            <p class="text-slate-600 max-w-2xl mx-auto mb-12">
                {{ $profilSekolah->visi ?? 'Sambutan kepala sekolah dan sejarah singkat akan tampil di sini.' }}
            </p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <div class="text-4xl font-extrabold text-blue-900" data-counter data-target="{{ $siswaAktif ?? 0 }}">0</div>
                    <div class="text-sm text-slate-500 mt-1">Siswa Aktif</div>
                </div>
                <div>
                    <div class="text-4xl font-extrabold text-blue-900" data-counter data-target="{{ $jumlahGuruStaf ?? 0 }}">0</div>
                    <div class="text-sm text-slate-500 mt-1">Guru & Staf</div>
                </div>
                <div>
                    <div class="text-4xl font-extrabold text-blue-900" data-counter data-target="{{ $jumlahJurusan ?? 0 }}">0</div>
                    <div class="text-sm text-slate-500 mt-1">Jurusan</div>
                </div>
                <div>
                    <div class="text-4xl font-extrabold text-blue-900" data-counter data-target="{{ $alumniPersen ?? 0 }}">0</div>
                    <div class="text-sm text-slate-500 mt-1">% Alumni Terserap</div>
                </div>
            </div>

            <a href="{{ route('profil-sekolah') }}" class="inline-block mt-10 text-blue-700 font-semibold hover:underline">
                Lihat Profil Lengkap &rarr;
            </a>
        </div>
    </section>

    {{-- CAROUSEL GURU --}}
    <section data-fade-in class="bg-blue-50 py-20 px-6 opacity-0 translate-y-8 transition duration-700 overflow-hidden">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-blue-950 text-center mb-12">Guru & Tenaga Pengajar</h2>
            <div class="overflow-hidden">
                <div id="carousel-guru" class="flex gap-6 w-max">
                    @forelse($gurus as $guru)
                        <div class="flex-shrink-0 w-48 bg-white rounded-2xl shadow-sm p-4 text-center">
                            @if(!empty($guru->foto))
                                <img src="{{ Storage::url($guru->foto) }}" alt="{{ $guru->nama }}" class="w-full aspect-square object-cover rounded-xl mb-3">
                            @else
                                <div class="w-full aspect-square bg-blue-100 rounded-xl mb-3 flex items-center justify-center text-blue-400 font-bold text-xl">
                                    {{ substr($guru->nama, 0, 1) }}
                                </div>
                            @endif
                            <div class="font-semibold text-blue-950 truncate">{{ $guru->nama }}</div>
                            <div class="text-sm text-slate-500 truncate">{{ $guru->jabatan }}</div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm">Belum ada data guru.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- JURUSAN --}}
    <section data-fade-in class="py-20 px-6 opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-blue-950 text-center mb-12">Kompetensi Keahlian</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($jurusans as $jurusan)
                    <a href="{{ route('jurusan.show', $jurusan->slug) }}" class="block bg-white border border-blue-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-lg mb-4 overflow-hidden {{ $jurusan->icon ? '' : 'bg-blue-900 flex items-center justify-center' }}"> @if($jurusan->icon) 
                        <img src="{{ Storage::url($jurusan->icon) }}" alt="{{ $jurusan->nama }}" class="w-full h-full object-contain"> @endif </div>
                        <div class="font-semibold text-blue-950">{{ $jurusan->nama }}</div>
                        <p class="text-sm text-slate-500 mt-2">{{ Str::limit($jurusan->deskripsi, 70) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- GALERI --}}
    <section data-fade-in class="bg-blue-50 py-20 px-6 opacity-0 translate-y-8 transition duration-700 overflow-hidden">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-blue-950 text-center mb-12">Galeri Kegiatan</h2>
            <div class="overflow-hidden">
                <div id="carousel-galeri" class="flex gap-6 w-max">
                    @forelse($galeris as $galeri)
                        <div class="flex-shrink-0 w-64">
                           @if(!empty($galeri->foto))
                                <img src="{{ Storage::url($galeri->foto) }}" alt="{{ $galeri->judul }}" class="w-full aspect-video object-cover rounded-xl mb-2">
                            @else
                                <div class="w-full aspect-video bg-blue-200 rounded-xl mb-2"></div>
                            @endif 
                            <div class="text-sm font-medium text-blue-950 truncate">{{ $galeri->judul }}</div>
                            <div class="text-xs text-slate-500">{{ $galeri->created_at->format('d M Y') }}</div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm">Belum ada galeri.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ARTIKEL --}}
    <section data-fade-in class="py-20 px-6 opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-blue-950 text-center mb-12">Artikel & Berita</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($artikels as $artikel)
                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="block bg-white border border-blue-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                        @if(!empty($artikel->thumbnail))
                            <img src="{{ Storage::url($artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="w-full aspect-video object-cover">
                        @else
                            <div class="w-full aspect-video bg-blue-100"></div>
                        @endif
                        <div class="p-5">
                            <span class="text-xs font-semibold text-blue-600 uppercase">{{ $artikel->kategori }}</span>
                            <h3 class="font-semibold text-blue-950 mt-1 line-clamp-2">{{ $artikel->judul }}</h3>
                            <div class="text-xs text-slate-400 mt-2">{{ $artikel->published_at?->format('d M Y') ?? $artikel->created_at->format('d M Y') }}</div>
                        </div>
                    </a>
                @empty
                    <p class="text-slate-400 text-sm">Belum ada artikel.</p>
                @endforelse
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('artikel.index') }}" class="text-blue-700 font-semibold hover:underline">Lihat Semua Artikel &rarr;</a>
            </div>
        </div>
    </section>

    {{-- KONTAK --}}
    <section id="kontak" data-fade-in class="bg-blue-950 text-white py-20 px-6 opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Hubungi Kami</h2>
            <p class="text-blue-200">{{ $profilSekolah->alamat ?? 'Alamat sekolah akan tampil di sini.' }}</p>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-counter]').forEach(el => {
                const target = parseInt(el.dataset.target, 10) || 0;
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            let current = 0;
                            const step = Math.max(1, Math.ceil(target / 60));
                            const interval = setInterval(() => {
                                current += step;
                                if (current >= target) {
                                    current = target;
                                    clearInterval(interval);
                                }
                                el.textContent = current;
                            }, 25);
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                observer.observe(el);
            });

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

            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);

                // Hero Stacking Effect
                const hero = document.querySelector('#hero-section');
                if (hero) {
                    gsap.to(hero, {
                        scale: 0.92,
                        opacity: 0.4,
                        filter: 'blur(2px)',
                        ease: 'none',
                        scrollTrigger: {
                            trigger: hero,
                            start: 'top top',
                            end: 'bottom top',
                            scrub: true,
                        }
                    });
                }

                function initInfiniteCarousel(trackSelector) {
                    const track = document.querySelector(trackSelector);
                    if (!track || track.children.length === 0) return;

                    const originalContent = track.innerHTML;
                    track.innerHTML = originalContent + originalContent;

                    const totalWidth = track.scrollWidth / 2;

                    const tween = gsap.to(track, {
                        x: -totalWidth,
                        duration: totalWidth / 40,
                        ease: 'none',
                        repeat: -1,
                    });

                    track.addEventListener('mouseenter', () => tween.pause());
                    track.addEventListener('mouseleave', () => tween.play());
                }

                initInfiniteCarousel('#carousel-guru');
                initInfiniteCarousel('#carousel-galeri');
            }
        });
    </script>
@endsection