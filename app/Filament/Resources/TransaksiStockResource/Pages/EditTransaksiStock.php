<?php

namespace App\Filament\Resources\TransaksiStockResource\Pages;

use App\Filament\Resources\TransaksiStockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaksiStock extends EditRecord
{
    protected static string $resource = TransaksiStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
