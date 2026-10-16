<x-filament-panels::page.simple>
    <div style="text-align:center; margin-bottom:1.5rem;">
        <div style="width:4rem; height:4rem; margin:0 auto 1rem; border-radius:1rem; background:linear-gradient(135deg,#172554,#1e40af); display:flex; align-items:center; justify-content:center; box-shadow:0 10px 15px -3px rgba(23,37,84,.3);">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:2rem; height:2rem; color:#ffffff;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
            </svg>
        </div>
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