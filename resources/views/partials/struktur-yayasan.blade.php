@php
    $p = $profilSekolah ?? $profil ?? null;
    $pengurus = collect(preg_split('/\R/', (string) ($p?->struktur_yayasan)))
        ->map(fn ($b) => array_map('trim', array_pad(explode('|', $b), 2, '')))
        ->filter(fn ($x) => $x[0] !== '')
        ->values();
@endphp

@if($pengurus->count())
<section class="py-16">
    <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-2">Yayasan</p>
    <h2 class="text-2xl md:text-3xl font-extrabold text-brand-950 tracking-tight mb-8">Struktur Yayasan</h2>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($pengurus as [$nama, $jabatan])
            <div class="card-lift flex items-center gap-4 bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                <div class="w-12 h-12 shrink-0 rounded-xl bg-brand-600 text-white font-bold flex items-center justify-center">
                    {{ strtoupper(substr(preg_replace('/^(Drs\.|Dr\.|Ir\.|H\.|Hj\.)\s*/i', '', $nama), 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-brand-950 leading-snug">{{ $nama }}</div>
                    @if($jabatan)<div class="text-sm text-brand-600 font-medium mt-0.5">{{ $jabatan }}</div>@endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif