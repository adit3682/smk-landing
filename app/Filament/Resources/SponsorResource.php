<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SponsorResource\Pages;
use App\Filament\Resources\SponsorResource\RelationManagers;
use App\Models\Sponsor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

    class SponsorResource extends Resource
    {
        protected static ?string $model = Sponsor::class;
    
        protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
        public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')
                ->required(),
    
            Forms\Components\FileUpload::make('logo')
                ->image()
                ->directory('sponsor')
                ->imageEditor()
                ->saveUploadedFileUsing(
                    \App\Support\ImageUpload::webp('sponsor')
                )
                ->required(),
    
            Forms\Components\TextInput::make('url')
                ->label('Link Website (opsional)')
                ->url()
                ->placeholder('https://...'),
    
            Forms\Components\TextInput::make('urutan')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('urutan')
                    ->numeric()
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
            'index' => Pages\ListSponsors::route('/'),
            'create' => Pages\CreateSponsor::route('/create'),
            'edit' => Pages\EditSponsor::route('/{record}/edit'),
        ];
    }
}
