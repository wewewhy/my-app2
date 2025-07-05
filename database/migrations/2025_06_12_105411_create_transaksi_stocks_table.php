<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_stocks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('stock_id')
                ->references('id')->on('stocks')
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->string('keterangan');
            $table->string('jenis_transaksi'); // Debit/Kredit
            $table->unsignedInteger('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_stocks');
    }
};
