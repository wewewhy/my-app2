<?php

namespace App\Filament\Resources\GudangResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StocksRelationManager extends RelationManager
{
    protected static string $relationship = 'stocks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('barang_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('barang_id')
            ->columns([
                Tables\Columns\TextColumn::make('barang.nama')
                ->label('Barang')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                ->label('Balance')
                ->numeric(locale:'id')
                ->sortable(),
                Tables\Columns\TextColumn::make('gudang.satuan')
                ->label('satuan'),
            ])
            ->filters([
                TernaryFilter::make('stock_balance')

            ]);
    }
}
