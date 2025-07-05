<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;

class EditBarang extends EditRecord
{
    protected static string $resource = BarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(
            function () use ($record, $data) {
                $oldRecord = Barang::query()->lockForUpdate()
                    ->where('id', $record->id)
                    ->where('version', $data['version'])
                    ->first();
                if (is_null($oldRecord)) {
                    throw new \Exception('version sudah berubah, silahkan refresh');
                }
                $data['version'] = $data['version'] + 1;
                return parent::handleRecordUpdate($record, $data);
            }
        );
    }
}
