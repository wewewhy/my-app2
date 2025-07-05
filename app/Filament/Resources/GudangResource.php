<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GudangResource\Pages;
use App\Filament\Resources\GudangResource\RelationManagers;
use App\Filament\Resources\BarangResource\RelationManagers\StocksRelationManager;
use App\Models\Gudang;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GudangResource extends Resource
{
    protected static ?string $model = Gudang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('nama')
                ->label('Nama')
                ->required(),
            Toggle::make('aktif')
                ->label('Aktif')
                ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
                TextColumn::make('nama')
                    ->label('Nama'),
                IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean(),
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
            StocksRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGudangs::route('/'),
            'create' => Pages\CreateGudang::route('/create'),
            'edit' => Pages\EditGudang::route('/{record}/edit'),
        ];
    }
}
