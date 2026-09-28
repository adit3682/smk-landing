<?php

namespace App\Filament\Resources\ProfilSekolahResource\Pages;

use App\Filament\Resources\ProfilSekolahResource;
use Filament\Resources\Pages\ListRecords;

class ListProfilSekolahs extends ListRecords
{
    protected static string $resource = ProfilSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(): void
    {
        parent::mount();

        $record = \App\Models\ProfilSekolah::first();

        if ($record) {
            $this->redirect(ProfilSekolahResource::getUrl('edit', ['record' => $record]));
        }
    }
}