@extends('layouts.app')

@section('title', 'Beranda - ' . ($profilSekolah->nama_sekolah ?? 'SMK Teknologi Informasi'))

@section('content')


{{-- HERO --}}
<section id="hero-section" class="relative min-h-[100svh] flex items-center px-6 pt-32 pb-20 text-white overflow-hidden grain">

    @if($profilSekolah?->foto_background_hero)
        <img src="{{ Storage::url($profilSekolah->foto_background_hero) }}" alt="" fetchpriority="high"
             class="absolute inset-0 w-full h-full object-cover">
    @endif

    <div class="absolute inset-0 bg-gradient-to-br {{ $profilSekolah?->foto_background_hero ? 'from-brand-950/90 via-brand-900/80 to-brand-800/70' : 'from-brand-950 via-brand-900 to-brand-800' }}"></div>
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 70% 30%, rgba(89,166,255,.35) 0%, transparent 55%), radial-gradient(circle at 20% 80%, rgba(51,128,255,.2) 0%, transparent 50%);"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background-image: linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px); background-size: 48px 48px;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-0 sm:px-2 w-full grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">

        <div class="text-center lg:text-left">
            <h1 class="text-4xl sm:text-5xl lg:text-[3.4rem] font-extrabold leading-[1.12] tracking-tight mb-5">
                Mencetak Talenta<br>
                <span class="text-gradient">Digital Masa Depan</span><br>
                Indonesia
            </h1>
            <p class="text-brand-200/90 text-lg max-w-md mx-auto lg:mx-0 mb-9 leading-relaxed">
                {{ $profilSekolah->nama_sekolah ?? 'SMK TI Bina Citra Informatika Purwokerto' }} — modern, profesional, dan siap kerja di era digital.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-3 justify-center lg:justify-start">
                <a href="{{ route('spmb') }}"
                   class="inline-flex items-center gap-2 bg-white text-brand-900 font-semibold px-7 py-3.5 rounded-xl shadow-glow hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                    Daftar SPMB <span aria-hidden="true">&rarr;</span>
                </a>
                <a href="#jurusan"
                   class="inline-flex items-center gap-2 text-white/90 font-medium px-6 py-3.5 rounded-xl border border-white/20 hover:bg-white/10 transition">
                    Lihat Jurusan
                </a>
            </div>
        </div>

        <div class="relative flex justify-center lg:justify-end">
            <div class="relative w-full max-w-[420px]">
                <div class="absolute -inset-6 bg-brand-500/30 blur-3xl rounded-full"></div>

                <div class="relative float rounded-3xl overflow-hidden shadow-2xl border border-white/10">
                    @if($profilSekolah?->foto_hero)
                        <img src="{{ Storage::url($profilSekolah->foto_hero) }}" alt="{{ $profilSekolah->nama_sekolah }}"
                             class="w-full aspect-[4/5] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/60 via-transparent to-transparent"></div>
                    @else
                        <div class="w-full aspect-[4/5] bg-brand-800/60 flex items-center justify-center text-brand-300 text-sm">
                            Foto hero belum diupload
                        </div>
                    @endif
                </div>

                <div class="absolute -bottom-4 -left-2 sm:bottom-6 sm:-left-8 glass rounded-2xl px-4 py-3 shadow-card border border-white/40">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white font-bold">
                            {{ $jumlahJurusan ?? 0 }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-brand-950">Program Keahlian</div>
                            <div class="text-xs text-slate-500">Pilih sesuai minatmu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- SAMBUTAN KEPALA SEKOLAH --}}
@if($profilSekolah?->sambutan_kepala_sekolah)
    <section data-fade-in class="relative py-24 px-6 bg-white overflow-hidden opacity-0 translate-y-8 transition duration-700">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-50/80 to-transparent pointer-events-none"></div>

        <div class="relative max-w-6xl mx-auto grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">

            <div class="lg:col-span-5 order-2 lg:order-1">
                <div class="relative max-w-sm mx-auto lg:mx-0">
                    <div class="absolute -bottom-4 -right-4 w-full h-full rounded-2xl border-2 border-brand-200/60 -z-10"></div>
                    <div class="relative rounded-2xl overflow-hidden shadow-card aspect-[3/4] bg-brand-100">
                        @if($profilSekolah->foto_kepala_sekolah)
                            <img src="{{ Storage::url($profilSekolah->foto_kepala_sekolah) }}"
                                 alt="{{ $profilSekolah->nama_kepala_sekolah }}"
                                 class="w-full h-full object-cover object-top">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-brand-400 font-bold text-6xl">
                                {{ strtoupper(substr($profilSekolah->nama_kepala_sekolah ?? 'K', 0, 1)) }}
                            </div>
                        @endif
                        <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-brand-950/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                            <div class="font-bold text-lg leading-tight">{{ $profilSekolah->nama_kepala_sekolah ?? '-' }}</div>
                            <div class="text-sm text-brand-100/90 mt-0.5">Kepala Sekolah</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 order-1 lg:order-2">
                <div class="inline-flex items-center gap-2 text-brand-600 font-semibold text-xs tracking-widest uppercase mb-5">
                    <span class="w-8 h-px bg-brand-400"></span>
                    Sambutan Kepala Sekolah
                </div>
                <div class="relative">
                    <span class="absolute -top-4 -left-2 text-7xl font-serif text-brand-100 leading-none select-none" aria-hidden="true">&ldquo;</span>
                    <p class="relative text-slate-600 text-base md:text-lg leading-relaxed pl-4 md:pl-6 border-l-2 border-brand-200">
                        {!! nl2br(e($profilSekolah->sambutan_kepala_sekolah)) !!}
                    </p>
                </div>
                <div class="mt-8 text-sm text-slate-500">
                    <span class="font-semibold text-brand-950">{{ $profilSekolah->nama_kepala_sekolah ?? '-' }}</span>
                    <span class="mx-1.5 text-slate-300">&middot;</span>
                    Kepala Sekolah
                </div>
            </div>

        </div>
    </section>
@endif

{{-- Letakkan section MENGAPA MEMILIH KAMI yang sudah ada di sini, lalu lanjutkan dengan: --}}

{{-- TENTANG SEKOLAH + COUNTER --}}
<section data-fade-in class="relative py-20 px-6 bg-brand-950 text-white overflow-hidden opacity-0 translate-y-8 transition duration-700">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 80% 20%, #3380ff 0%, transparent 40%);"></div>

    <div class="relative max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div>
            <p class="text-brand-300 font-semibold text-sm tracking-wide uppercase mb-3">Tentang Sekolah</p>
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-5">
                {{ $profilSekolah->nama_sekolah ?? 'Tentang Sekolah Kami' }}
            </h2>
            @if($profilSekolah?->visi)
                <p class="text-brand-200/80 leading-relaxed mb-8">{{ $profilSekolah->visi }}</p>
            @endif
            <a href="{{ route('profil-sekolah') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-white border-b border-white/40 pb-0.5 hover:border-white transition">
                Lihat profil lengkap <span aria-hidden="true">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-2 gap-5">
            @foreach([
                [$siswaAktif ?? 0, 'Siswa Aktif'],
                [$jumlahGuruStaf ?? 0, 'Guru & Staf'],
                [$jumlahJurusan ?? 0, 'Jurusan'],
                [$alumniPersen ?? 0, '% Alumni Terserap'],
            ] as [$angka, $label])
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm">
                    <div class="text-3xl font-extrabold text-white mb-1" data-counter data-target="{{ $angka }}">0</div>
                    <div class="text-sm text-brand-300">{{ $label }}</div>
                </div>
            @endforeach
        </div>
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
    <section id="jurusan" data-fade-in class="py-20 px-6 bg-white opacity-0 translate-y-8 transition duration-700">
        <div class="max-w-6xl mx-auto">

            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Program Keahlian</span>
                <h2 class="text-3xl font-bold text-blue-950 mt-2">Kompetensi Keahlian</h2>
                <p class="text-slate-600 mt-3">
                    Pilih jurusan sesuai minat dan bakatmu, dan siapkan diri untuk dunia kerja.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($jurusans as $jurusan)
                    <a href="{{ route('jurusan.show', $jurusan->slug) }}"
                       class="group flex flex-col bg-white border border-blue-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">

                        <div class="relative aspect-square overflow-hidden bg-blue-50">
                            @if($jurusan->icon)
                                <img src="{{ Storage::url($jurusan->icon) }}"
                                     alt="{{ $jurusan->nama }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-950 to-blue-800 flex items-center justify-center text-white font-extrabold text-6xl">
                                    {{ strtoupper(substr($jurusan->nama, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col flex-1 p-6">
                            <h3 class="font-bold text-lg text-blue-950">{{ $jurusan->nama }}</h3>
                            <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                                {{ Str::limit($jurusan->deskripsi, 110) }}
                            </p>
                            <span class="mt-auto pt-5 inline-flex items-center gap-1 text-sm font-semibold text-blue-700 group-hover:gap-2 transition-all">
                                Lihat Jurusan <span aria-hidden="true">&rarr;</span>
                            </span>
                        </div>
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

      <section data-fade-in class="py-20 px-6 opacity-0 translate-y-8 transition duration-700">
      <div class="max-w-5xl mx-auto relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-700 via-brand-800 to-brand-950 px-8 py-16 text-center text-white">
          <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4">Siap Menjadi Talenta Digital?</h2>
          <p class="text-brand-200 max-w-lg mx-auto mb-8">
              Bergabunglah dengan {{ $profilSekolah->nama_sekolah ?? 'sekolah kami' }} dan wujudkan masa depan digitalmu.
          </p>
          <a href="{{ route('spmb') }}" class="inline-flex items-center gap-2 bg-white text-brand-900 font-bold px-8 py-4 rounded-xl shadow-lg hover:scale-[1.03] transition-transform">
              Daftar SPMB Sekarang <span aria-hidden="true">&rarr;</span>
          </a>
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