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
                ->label('Foto Siswa (sisi kanan hero)')
                ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('hero')),

            Forms\Components\FileUpload::make('foto_background_hero')
                ->image()
                ->directory('hero-bg')
                ->imageEditor()
                ->label('Foto Background Hero (foto gedung sekolah)')
                ->helperText('Gunakan foto landscape, lebar sekitar 1920 px.')
                ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('hero-bg', 85)),

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

            Forms\Components\TextInput::make('telepon')
                ->tel()
                ->placeholder('0281 1234567'),

            Forms\Components\TextInput::make('email')
                ->email()
                ->placeholder('info@smkbintra.sch.id'),

            Forms\Components\Section::make('Sambutan Kepala Sekolah')
                ->schema([
                    Forms\Components\FileUpload::make('foto_kepala_sekolah')
                        ->image()
                        ->directory('kepala-sekolah')
                        ->imageEditor()
                        ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('kepala-sekolah')),

                    Forms\Components\Textarea::make('sambutan_kepala_sekolah')
                        ->rows(5)
                        ->placeholder('Assalamu\'alaikum warahmatullahi wabarakatuh...'),
                ]),
                Forms\Components\Section::make('Mengapa Memilih Kami')
    ->description('Ditampilkan di Beranda')
    ->schema([
        Forms\Components\FileUpload::make('foto_mengapa_memilih')
            ->image()
            ->directory('mengapa-memilih')
            ->imageEditor()
            ->label('Foto')
            ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('mengapa-memilih')),

        Forms\Components\Textarea::make('mengapa_memilih_teks')
            ->label('Teks Penjelasan')
            ->rows(5)
            ->helperText('Kosongkan untuk memakai teks bawaan.'),
    ]),

            Forms\Components\Textarea::make('visi')
                ->columnSpanFull(),

            Forms\Components\Textarea::make('misi')
                ->columnSpanFull(),

            Forms\Components\Textarea::make('profil_yayasan')
                ->columnSpanFull(),

            Forms\Components\Textarea::make('struktur_yayasan')
                ->label('Struktur Yayasan')
                ->rows(6)
                ->columnSpanFull()
                ->helperText('Satu baris = satu pengurus. Format: Nama | Jabatan. Urutan tampil sesuai urutan baris.')
                ->placeholder("Drs. Haris Subyakto, SH.MH | Pembina Yayasan"),

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

                        Forms\Components\TextInput::make('spmb_tahun_ajaran')
                        ->label('Tahun Ajaran')
                        ->placeholder('2027/2028'),

                    Forms\Components\TextInput::make('spmb_biaya')
                        ->label('Biaya Pendaftaran')
                        ->placeholder('GRATIS'),

                    Forms\Components\Textarea::make('spmb_promo')
                        ->label('Promo / Penawaran Khusus')
                        ->placeholder('Dapatkan Spesial Gift untuk 10 Pendaftar Pertama')
                        ->rows(2),

                    Forms\Components\Textarea::make('persyaratan_pendaftaran')
                        ->label('Persyaratan Pendaftaran')
                        ->helperText('Satu baris = satu syarat')
                        ->rows(6)
                        ->placeholder("FC Kartu Keluarga\nFC Akte Kelahiran\nFC KTP Orang Tua\nFC Ijazah SMP/MTs\nFC KIP (jika ada)\nPas Foto 3x4"),

                    Forms\Components\Textarea::make('ekstrakurikuler')
                        ->label('Ekstrakurikuler')
                        ->helperText('Satu baris = satu ekskul')
                        ->rows(8)
                        ->placeholder("E-sport\nHadroh\nFutsal\nEngineering\nSoftware Engineering\nTari\nMusik\nVolly\nPMR\nPramuka"),

                    Forms\Components\Textarea::make('ekstrakurikuler')
                        ->label('Ekstrakurikuler')
                        ->helperText('Satu baris = satu ekskul')
                        ->rows(8)
                        ->placeholder("E-sport\nHadroh\nFutsal\nEngineering\nSoftware Engineering\nTari\nMusik\nVolly\nPMR\nPramuka"),

                        
                    Forms\Components\Textarea::make('spmb_gelombang')
                        ->label('Gelombang Pendaftaran')
                        ->rows(4)
                        ->helperText('Satu gelombang per baris. Format: Judul | Periode | Keterangan.')
                        ->placeholder("Gelombang 1 | Sep 2026 - Jan 2027 | Kuota terbatas"),

                    Forms\Components\Textarea::make('spmb_prestasi')
                        ->label('Prestasi Siswa')
                        ->rows(6)
                        ->helperText('Satu prestasi per baris.'),

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
