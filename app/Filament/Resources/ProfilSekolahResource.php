<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilSekolahResource\Pages;
use App\Filament\Resources\ProfilSekolahResource\RelationManagers;
use App\Models\ProfilSekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfilSekolahResource extends Resource
{
    protected static ?string $model = ProfilSekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('nama_sekolah')
                ->required()
                ->maxLength(255),

            Forms\Components\FileUpload::make('foto_hero')
                ->image()
                ->directory('hero')
                ->imageEditor()
                ->label('Foto Background Hero')
                ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('hero')),

            Forms\Components\FileUpload::make('logo')
                ->image()
                ->directory('logo')
                ->imageEditor()
                ->label('Logo Sekolah')
                ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('logo')),

            Forms\Components\TextInput::make('npsn')
                ->maxLength(255)
                ->default(null),

            Forms\Components\Textarea::make('alamat')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('kode_pos')
                ->maxLength(255)
                ->default(null),

            Forms\Components\TextInput::make('nama_kepala_sekolah')
                ->maxLength(255)
                ->default(null),

            Forms\Components\Textarea::make('visi')
                ->columnSpanFull(),

            Forms\Components\Textarea::make('misi')
                ->columnSpanFull(),

            Forms\Components\Textarea::make('profil_yayasan')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('instagram')
                ->url()
                ->placeholder('https://instagram.com/namaakun'),

            Forms\Components\TextInput::make('tiktok')
                ->url()
                ->placeholder('https://tiktok.com/@namaakun'),

            // SPMB
            Forms\Components\Section::make('SPMB')
                ->description('Ditampilkan di halaman /spmb')
                ->schema([
                    Forms\Components\FileUpload::make('spmb_posters')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->directory('spmb')
                        ->imageEditor()
                        ->saveUploadedFileUsing(
                            \App\Support\ImageUpload::webp('spmb', 90)
                        )
                        ->label('Poster SPMB (bisa lebih dari satu)'),

                    Forms\Components\TextInput::make('spmb_link')
                        ->url()
                        ->label('Link Pendaftaran')
                        ->placeholder('https://...'),

                    Forms\Components\TextInput::make('spmb_whatsapp')
                        ->label('Nomor WhatsApp')
                        ->placeholder('081234567890')
                        ->helperText(
                            'Tulis angka saja, tanpa spasi atau tanda hubung.'
                        ),
                ]),

                 // GOOGLE MAPS
            Forms\Components\Textarea::make('gmaps_embed')
                ->label('Google Maps (kode sematkan)')
                ->rows(3)
                ->helperText(
                    'Google Maps → cari lokasi sekolah → Bagikan → Sematkan peta → Salin HTML, lalu tempel di sini.'
                )
                ->rules([
                    fn () => function (string $attribute, $value, \Closure $fail) {
                        if (
                            $value &&
                            ! str_contains($value, 'google.com/maps/embed')
                        ) {
                            $fail(
                                'Isi dengan kode sematkan dari Google Maps (menu Sematkan peta), bukan link biasa.'
                            );
                        }
                    },
                ]),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->searchable(),

                Tables\Columns\TextColumn::make('npsn')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kode_pos')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_kepala_sekolah')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfilSekolahs::route('/'),
            'create' => Pages\CreateProfilSekolah::route('/create'),
            'edit' => Pages\EditProfilSekolah::route('/{record}/edit'),
        ];
    }
}
