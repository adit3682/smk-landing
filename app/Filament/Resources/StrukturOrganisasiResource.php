<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StrukturOrganisasiResource\Pages;
use App\Filament\Resources\StrukturOrganisasiResource\RelationManagers;
use App\Models\StrukturOrganisasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StrukturOrganisasiResource extends Resource
{
    protected static ?string $model = StrukturOrganisasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jabatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_pejabat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pejabat')
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
            'index' => Pages\ListStrukturOrganisasis::route('/'),
            'create' => Pages\CreateStrukturOrganisasi::route('/create'),
            'edit' => Pages\EditStrukturOrganisasi::route('/{record}/edit'),
        ];
    }
}
