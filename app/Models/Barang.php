<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
        'nama',
        'barcode',
        'satuan',
        'version',
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'barang_id', 'id');
    }
}
