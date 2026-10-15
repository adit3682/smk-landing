<?php

namespace App\Filament\Resources\JurusanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class KegiatansRelationManager extends RelationManager
{
    protected static string $relationship = 'kegiatans';

    protected static ?string $title = 'Kegiatan (KI, Outing Class, PKL, dll)';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategori')
                    ->options([
                        'KI' => 'Kunjungan Industri',
                        'Outing Class' => 'Outing Class',
                        'PKL' => 'Praktik Kerja Lapangan (PKL)',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('tanggal'),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->directory('jurusan-kegiatan')
                    ->imageEditor()
                    ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('jurusan-kegiatan'))
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul')
            ->columns([
                Tables\Columns\ImageColumn::make('foto'),
                Tables\Columns\TextColumn::make('kategori')->badge(),
                Tables\Columns\TextColumn::make('judul')->searchable(),
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}