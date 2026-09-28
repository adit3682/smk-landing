<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AkreditasiResource\Pages;
use App\Filament\Resources\AkreditasiResource\RelationManagers;
use App\Models\Akreditasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AkreditasiResource extends Resource
{
    protected static ?string $model = Akreditasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('peringkat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('lembaga_penerbit')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('tahun_berlaku'),
                Forms\Components\FileUpload::make('file_sertifikat')
                    ->directory('sertifikat'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('peringkat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lembaga_penerbit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_berlaku'),
                Tables\Columns\TextColumn::make('file_sertifikat')
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
            'index' => Pages\ListAkreditasis::route('/'),
            'create' => Pages\CreateAkreditasi::route('/create'),
            'edit' => Pages\EditAkreditasi::route('/{record}/edit'),
        ];
    }
}
