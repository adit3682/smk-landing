<?php

namespace App\Filament\Resources\DataSiswaTahunanResource\Pages;

use App\Filament\Resources\DataSiswaTahunanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataSiswaTahunans extends ListRecords
{
    protected static string $resource = DataSiswaTahunanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
