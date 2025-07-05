<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Filament\Resources\BarangResource\RelationManagers\StocksRelationManager;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama'),
                TextInput::make('barcode'),
                TextInput::make('satuan'),
                TextInput::make('version')->readOnly(),
                Placeholder::make('total_stock')
                    ->visibleOn(['edit', 'view'])
                    ->content(fn (Model $record) 
                    => "{$record->totalStock} {$record->satuan}"),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('barcode'),
                TextColumn::make('satuan'),
                TextColumn::make('totalStock'),
            ])
            ->filters([
                TernaryFilter::make('stock_balance')
                    ->placeholder('Semua')
                    ->trueLabel('Ada Stock')
                    ->falseLabel('Stock Kosong')
                    ->queries(
                        blank: fn ($q) => $q,
                        true: fn ($q) => $q->hasStock(),
                        false: fn ($q) => $q->noStock(),
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // eager load data barang beserta relasi stocks untuk
            // mengatasi masalah N+1 query (karena totalStock dihitung menggunakan
            // relasi stocks)
            ->modifyQueryUsing(fn (Builder $query) 
                => $query->with(['stocks']));
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StocksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}