<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiStockResource\Pages;
use App\Filament\Resources\TransaksiStockResource\RelationManagers;
use App\JenisTransaksi;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\TransaksiStock;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class TransaksiStockResource extends Resource
{
    protected static ?string $model = TransaksiStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->format('Y-m-d')
                    ->default(Carbon::today())
                    ->required(),
                Select::make('barang')
                    ->label('Barang')
                    ->options(Barang::all()->pluck('nama', 'id'))
                    ->required(),
                Select::make('gudang')
                    ->label('Gudang')
                    ->options(Gudang::all()->pluck('nama', 'id'))
                    ->required(),
                TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->required(),
                Select::make('jenis_transaksi')
                    ->label('Jenis Transaksi')
                    ->options(JenisTransaksi::class)
                    ->required(),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->required()
                    ->minValue(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->sortable(),
                TextColumn::make('stock.barang.nama')
                    ->label('Barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('stock.gudang.nama')
                    ->label('Gudang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jenis_transaksi')
                    ->label('Jenis Transaksi')
                    ->sortable(),
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric(locale: 'id')
                    ->sortable(),
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
            'index' => Pages\ListTransaksiStocks::route('/'),
            'create' => Pages\CreateTransaksiStock::route('/create'),
            'edit' => Pages\EditTransaksiStock::route('/{record}/edit'),
        ];
    }
}