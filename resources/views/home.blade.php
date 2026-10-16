@extends('layouts.app')

@section('title', 'Beranda - ' . ($profilSekolah->nama_sekolah ?? 'SMK Teknologi Informasi'))

@section('content')

    {{-- HERO --}}
    <section id="hero-section" class="relative min-h-[90vh] flex items-center px-6 pt-28 pb-16 bg-blue-950 text-white overflow-hidden">

        {{-- background foto sekolah --}}
        @if($profilSekolah?->foto_background_hero)
            <img src="{{ Storage::url($profilSekolah->foto_background_hero) }}"
                 alt=""
                 fetchpriority="high"
                 class="absolute inset-0 w-full h-full object-cover">
        @endif

        {{-- overlay biru: lebih transparan kalau ada foto --}}
        <div class="absolute inset-0 bg-gradient-to-br {{ $profilSekolah?->foto_background_hero ? 'from-blue-950/90 via-blue-900/75 to-blue-800/60' : 'from-blue-950 via-blue-900 to-blue-800' }}"></div>

        {{-- dekorasi titik-titik, murni visual --}}
        <div class="absolute -right-10 top-10 w-40 h-40 opacity-10" style="background-image: radial-gradient(circle, white 1.5px, transparent 1.5px); background-size: 16px 16px;"></div>

        <div class="relative z-10 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">

            {{-- Kiri: headline --}}
            <div class="text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-5">
                    Mencetak Talenta Digital<br>
                    Masa Depan Indonesia
                </h1>
                <p class="text-blue-200 text-lg mb-8 max-w-md mx-auto lg:mx-0">
                    {{ $profilSekolah->nama_sekolah ?? 'SMK TI Bina Citra Informatika Purwokerto' }} — modern, profesional, dan siap kerja.
                </p>
                <a href="{{ route('spmb') }}" class="inline-block bg-white text-blue-900 font-semibold px-8 py-3 rounded-full hover:bg-blue-100 transition">
                    SPMB
                </a>
            </div>

            {{-- Kanan: foto --}}
            <div class="flex justify-center lg:justify-end">
                @if($profilSekolah?->foto_hero)
                    <img src="{{ Storage::url($profilSekolah->foto_hero) }}"
                         alt="{{ $profilSekolah->nama_sekolah }}"
                         class="w-full max-w-md rounded-3xl shadow-2xl object-cover aspect-[4/5]">
                @else
                    <div class="w-full max-w-md aspect-[4/5] rounded-3xl bg-blue-800/60 border border-blue-700 flex items-center justify-center text-blue-300 text-sm">
                        Foto hero belum diupload
                    </div>
                @endif
            </div>

        </div>
    </section>

    {{-- SAMBUTAN KEPALA SEKOLAH --}}
    @if($profilSekolah?->sambutan_kepala_sekolah)
        <section data-fade-in class="py-20 px-6 opacity-0 translate-y-8 transition duration-700">
            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 items-center">

                <div class="md:col-span-1 flex justify-center">
                    @if($profilSekolah->foto_kepala_sekolah)
                        <img src="{{ Storage::url($profilSekolah->foto_kepala_sekolah) }}"
                             alt="{{ $profilSekolah->nama_kepala_sekolah }}"
                             class="w-48 h-48 rounded-full object-cover shadow-md">
                    @else
                        <div class="w-48 h-48 rounded-full bg-blue-100 flex items-center justify-center text-blue-400 font-bold text-4xl">
                            {{ substr($profilSekolah->nama_kepala_sekolah ?? 'K', 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="md:col-span-2 text-center md:text-left">
                    <span class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Sambutan Kepala Sekolah</span>
                    <p class="text-slate-600 italic leading-relaxed mt-4 mb-5">
                        "{{ $profilSekolah->sambutan_kepala_sekolah }}"
                    </p>
                    <div class="font-bold text-blue-950">{{ $profilSekolah->nama_kepala_sekolah ?? '-' }}</div>
                    <div class="text-sm text-slate-500">Kepala Sekolah</div>
                </div>

            </div>
        </section>
    @endif

        {{-- MENGAPA MEMILIH KAMI --}}
    <section id="mengapa-memilih" data-fade-in class="py-16 px-4 sm:px-6 bg-white opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

            <div>
                @if($profilSekolah?->foto_mengapa_memilih)
                    <img src="{{ Storage::url($profilSekolah->foto_mengapa_memilih) }}"
                         alt="Mengapa memilih {{ $profilSekolah->nama_sekolah ?? 'sekolah kami' }}"
                         loading="lazy"
                         class="w-full aspect-[16/9] object-cover shadow-md">
                @else
                    <div class="w-full aspect-[16/9] bg-blue-100 flex items-center justify-center text-blue-400 text-sm">
                        Foto belum diupload
                    </div>
                @endif
            </div>

            <div class="text-center lg:text-left">
                <h2 class="font-serif text-3xl sm:text-4xl font-bold leading-tight">
                    <span class="text-amber-500">Mengapa memilih</span><br>
                    <span class="text-slate-900">{{ $profilSekolah->nama_sekolah ?? 'SMK Kami' }} ?</span>
                </h2>

                @if($profilSekolah?->mengapa_memilih_teks)
                    <p class="mt-5 text-slate-600 leading-8 text-justify">
                        {!! nl2br(e($profilSekolah->mengapa_memilih_teks)) !!}
                    </p>
                @else
                    <p class="mt-5 text-slate-600 leading-8 text-justify">
                        <strong class="text-slate-900">{{ $profilSekolah->nama_sekolah ?? 'Sekolah kami' }}</strong>
                        dikenal sebagai sekolah kejuruan yang berwawasan teknologi dalam mencetak lulusan
                        yang <strong class="text-slate-900">kompeten, berkarakter, dan siap kerja</strong>,
                        serta mampu bersaing di dunia usaha dan dunia industri.
                    </p>
                @endif

                <a href="{{ route('profil-sekolah') }}"
                   class="inline-block mt-8 px-8 py-3 rounded-full bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium transition">
                    Selengkapnya
                </a>
            </div>

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
                        <div class="w-20 h-20 rounded-lg mb-5 overflow-hidden {{ $jurusan->icon ? '' : 'bg-blue-900 flex items-center justify-center' }}"> @if($jurusan->icon)
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

    {{-- BERITA & ACARA (carousel) --}}
    @php
        $beritaList = $artikels ?? collect();
    @endphp

    @if ($beritaList->count())
    <section id="berita" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <h2 class="text-center font-serif text-3xl sm:text-4xl font-bold text-amber-500 mb-10">
                Berita &amp; Acara
            </h2>

            <div id="berita-carousel" class="relative">
                <div id="berita-track"
                     class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2"
                     style="scrollbar-width: none; -ms-overflow-style: none;">
                    @foreach ($beritaList as $a)
                        @php
                            $judul   = $a->judul ?? $a->title;
                            $gambar  = $a->gambar ?? $a->thumbnail ?? $a->foto ?? null;
                            $tanggal = $a->published_at ?? $a->created_at;
                            $ringkas = \Illuminate\Support\Str::limit(
                                strip_tags($a->ringkasan ?? $a->excerpt ?? $a->isi ?? $a->konten ?? ''), 140
                            );
                            $url     = route('artikel.show', $a->slug);
                        @endphp

                        <article class="berita-card snap-start shrink-0 w-full md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)]">
                            <a href="{{ $url }}" class="block overflow-hidden bg-slate-100 aspect-[3/2]">
                                @if ($gambar)
                                    <img src="{{ asset('storage/' . $gambar) }}" alt="{{ $judul }}"
                                         loading="lazy" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                                        Belum ada gambar
                                    </div>
                                @endif
                            </a>

                            <h3 class="mt-3 font-serif text-xl font-semibold text-slate-900 leading-snug line-clamp-3">
                                <a href="{{ $url }}">{{ $judul }}</a>
                            </h3>

                            <p class="mt-3 text-sm text-sky-600">
                                {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('F j, Y') }}
                            </p>

                            <p class="mt-3 text-slate-600 text-sm leading-7 line-clamp-3">{{ $ringkas }}</p>

                            <a href="{{ $url }}"
                               class="inline-block mt-5 px-7 py-3 rounded bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium transition">
                                Selengkapnya
                            </a>
                        </article>
                    @endforeach
                </div>

                <div id="berita-dots" class="flex justify-center gap-3 mt-8"></div>
            </div>
        </div>
    </section>

    <script>
    (function () {
        const track = document.getElementById('berita-track');
        const dotsBox = document.getElementById('berita-dots');
        if (!track || !dotsBox) return;

        const cards = track.querySelectorAll('.berita-card');
        let pages = 1, current = 0, timer;

        const perView = () => window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);

        function build() {
            pages = Math.max(1, Math.ceil(cards.length / perView()));
            dotsBox.innerHTML = '';
            for (let i = 0; i < pages; i++) {
                const b = document.createElement('button');
                b.type = 'button';
                b.setAttribute('aria-label', 'Halaman ' + (i + 1));
                b.className = 'w-3 h-3 rounded-full transition';
                b.addEventListener('click', () => { go(i); restart(); });
                dotsBox.appendChild(b);
            }
            paint();
        }

        function paint() {
            [...dotsBox.children].forEach((d, i) => {
                d.style.background = i === current ? '#f59e0b' : '#1fa6b8';
            });
        }

        function go(i) {
            current = (i + pages) % pages;
            const card = cards[Math.min(current * perView(), cards.length - 1)];
            track.scrollTo({ left: card.offsetLeft - track.offsetLeft, behavior: 'smooth' });
            paint();
        }

        let t;
        track.addEventListener('scroll', () => {
            clearTimeout(t);
            t = setTimeout(() => {
                const w = cards[0].offsetWidth + 24;
                current = Math.min(pages - 1, Math.round(track.scrollLeft / (w * perView())));
                paint();
            }, 80);
        });

        function restart() { clearInterval(timer); timer = setInterval(() => go(current + 1), 5000); }

        window.addEventListener('resize', () => { current = 0; build(); });
        build();
        restart();
    })();
    </script>
    @endif

    {{-- FASILITAS --}}
    @if (isset($sarpras) && $sarpras->count())
    <section id="fasilitas" data-fade-in class="py-16 px-4 sm:px-6 bg-white opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-10">
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-amber-500">Fasilitas</h2>
                <p class="mt-3 text-slate-600">
                    <strong class="text-slate-900">{{ $profilSekolah->nama_sekolah ?? 'Sekolah kami' }}</strong>
                    menyediakan fasilitas terbaik untuk mendukung kegiatan belajar mengajar.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2">
                @foreach ($sarpras as $item)
                    <a href="{{ route('fasilitas') }}"
                       class="group relative block aspect-square overflow-hidden rounded-2xl bg-slate-200">
                        @if (!empty($item->foto))
                            <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}" loading="lazy"
                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-blue-100"></div>
                        @endif

                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition"></div>

                        <div class="absolute inset-x-0 bottom-0 p-4 text-white text-sm font-semibold
                                    opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition">
                            {{ $item->nama }}
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('fasilitas') }}"
                   class="inline-block px-8 py-3 rounded-full bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium transition">
                    Lihat Semua Fasilitas
                </a>
            </div>

        </div>
    </section>
    @endif

    {{-- KONTAK / LOKASI --}}
    <section id="kontak" data-fade-in class="bg-blue-950 text-white py-20 px-6 opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

            <div>
                <p class="text-blue-300 text-xs uppercase tracking-wider mb-3">Alamat</p>
                <p class="text-xl md:text-2xl font-semibold leading-relaxed">
                    {!! nl2br(e($profilSekolah->alamat ?? 'Alamat sekolah akan tampil di sini.')) !!}
                </p>
            </div>

            <div>
                @if($profilSekolah?->gmaps_embed_url)
                    <iframe src="{{ $profilSekolah->gmaps_embed_url }}"
                            class="w-full h-80 rounded-2xl border-0"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi sekolah di Google Maps"></iframe>
                @else
                    <div class="w-full h-80 rounded-2xl bg-blue-900/50 flex items-center justify-center text-blue-300 text-sm">
                        Peta belum tersedia
                    </div>
                @endif
            </div>

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