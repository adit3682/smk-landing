<x-filament-panels::page.simple>
    <div class="mb-6 text-center">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-950 to-blue-800 shadow-lg">
            <span class="text-xl font-bold text-white">TI</span>
        </div>
        <h1 class="text-lg font-bold text-blue-950">SMK TI Bina Citra Informatika</h1>
        <p class="text-sm text-gray-500">Panel Admin</p>
    </div>

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page.simple>