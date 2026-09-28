<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanKeuanganResource\Pages;
use App\Filament\Resources\LaporanKeuanganResource\RelationManagers;
use App\Models\LaporanKeuangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanKeuanganResource extends Resource
{
    protected static ?string $model = LaporanKeuangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\TextInput::make('judul')
            ->required()
            ->placeholder('Rekapitulasi Realisasi Penggunaan Dana BOSP'),

        Forms\Components\TextInput::make('periode')
            ->placeholder('01 Januari 2026 s/d 30 Juni 2026'),

        Forms\Components\TextInput::make('tahun')
            ->numeric()
            ->required()
            ->default(date('Y')),

        Forms\Components\TextInput::make('tahap')
            ->placeholder('Tahap 1'),

        Forms\Components\TextInput::make('sumber_dana')
            ->placeholder('BOS Reguler'),

        Forms\Components\FileUpload::make('gambar')
            ->image()
            ->directory('laporan')
            ->imageEditor()
            ->label('Gambar Laporan (hasil scan)'),

        Forms\Components\FileUpload::make('file_pdf')
            ->directory('laporan')
            ->acceptedFileTypes(['application/pdf'])
            ->label('File PDF (untuk diunduh)'),

        Forms\Components\Textarea::make('keterangan')
            ->rows(2)
            ->columnSpanFull(),

        Forms\Components\TextInput::make('urutan')
            ->numeric()
            ->default(0),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanKeuangans::route('/'),
            'create' => Pages\CreateLaporanKeuangan::route('/create'),
            'edit' => Pages\EditLaporanKeuangan::route('/{record}/edit'),
        ];
    }
}
