<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Filament\Resources\ArtikelResource\RelationManagers;
use App\Models\Artikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\TextInput::make('judul')
            ->required()
            ->live(onBlur: true)
            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

        Forms\Components\TextInput::make('slug')
            ->required()
            ->unique(ignoreRecord: true),

        Forms\Components\Select::make('kategori')
            ->options([
                'prestasi' => 'Prestasi',
                'kegiatan' => 'Kegiatan',
                'pengumuman' => 'Pengumuman',
                'berita' => 'Berita',
            ])
            ->required(),

        Forms\Components\FileUpload::make('thumbnail')
            ->image()
            ->directory('artikel')
            ->imageEditor()
            ->saveUploadedFileUsing(\App\Support\ImageUpload::webp('artikel')),

        Forms\Components\Textarea::make('excerpt')
            ->rows(2)
            ->maxLength(255),

        Forms\Components\RichEditor::make('konten')
            ->required()
            ->columnSpanFull(),

        Forms\Components\Select::make('status')
            ->options(['draft' => 'Draft', 'publish' => 'Publish'])
            ->default('draft')
            ->required(),

        Forms\Components\Toggle::make('pinned')
            ->label('Sematkan di beranda'),

        Forms\Components\DateTimePicker::make('published_at'),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('thumbnail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\IconColumn::make('pinned')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}
