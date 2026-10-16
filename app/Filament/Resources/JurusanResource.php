<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurusanResource\Pages;
use App\Filament\Resources\JurusanResource\RelationManagers;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JurusanResource extends Resource
{
    protected static ?string $model = Jurusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tema')
                    ->label('Warna halaman')
                    ->options([
                        'blue'   => 'Biru',
                        'violet' => 'Ungu',
                        'orange' => 'Oranye',
                    ])
                     ->placeholder('Otomatis (ikut nama jurusan)'),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('kurikulum')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('keterampilan')
    ->label('Keterampilan yang Dipelajari')
    ->helperText('Satu baris = satu kompetensi. Boleh pakai format "Judul: penjelasan singkat".')
    ->columnSpanFull(),
Forms\Components\Textarea::make('prospek_kerja')
    ->helperText('Satu baris = satu pekerjaan (tampil sebagai kartu). Boleh "Judul: penjelasan singkat". Kalau hanya satu paragraf, tampil sebagai teks biasa.')
    ->columnSpanFull(),
                 Forms\Components\FileUpload::make('icon') ->image() ->directory('jurusan') 
                    ->imageEditor() 
                    ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('jurusan')) 
                    ->label('Icon Jurusan'),
                Forms\Components\FileUpload::make('foto_utama')
                    ->image()
                    ->directory('jurusan-utama')
                    ->imageEditor()
                    ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('jurusan-utama'))
                    ->label('Foto Utama Jurusan')
                    ->helperText('Foto siswa/kegiatan yang mewakili jurusan ini, ditampilkan besar di halaman detail'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\KegiatansRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJurusans::route('/'),
            'create' => Pages\CreateJurusan::route('/create'),
            'edit' => Pages\EditJurusan::route('/{record}/edit'),
        ];
    }
}
