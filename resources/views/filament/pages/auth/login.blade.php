@php
    $profilLogin = \App\Models\ProfilSekolah::first();
    $logoSekolah = $profilLogin?->logo ? \Illuminate\Support\Facades\Storage::url($profilLogin->logo) : null;
@endphp

<x-filament-panels::page.simple>

    {{-- LOGO ADMIN (orang): dipindah ke paling atas, di atas tulisan "Sign in" --}}
    <div style="order:-1; text-align:center;">
        <div style="width:4rem; height:4rem; margin:0 auto; border-radius:1rem; background:linear-gradient(135deg,#172554,#1e40af); display:flex; align-items:center; justify-content:center; box-shadow:0 10px 15px -3px rgba(23,37,84,.3);">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:2rem; height:2rem; color:#ffffff;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </div>
    </div>

    {{-- LOGO SEKOLAH + NAMA: sekarang di bawah tulisan "Sign in" --}}
    <div style="text-align:center; margin-bottom:1.5rem;">
        @if($logoSekolah)
            <img src="{{ $logoSekolah }}" alt="Logo sekolah" style="height:4rem; width:auto; margin:0 auto 1rem; object-fit:contain;">
        @endif
        <h1 style="font-size:1.125rem; font-weight:700;">SMK TI Bina Citra Informatika</h1>
        <p style="font-size:.875rem; opacity:.65;">Panel Admin</p>
    </div>

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page.simple>