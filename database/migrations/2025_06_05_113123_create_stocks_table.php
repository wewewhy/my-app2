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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')
                ->references('id')
                ->on('barangs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('gudang_id')
                ->references('id')
                ->on('gudangs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedInteger('balance')
                ->default(0); // saldo stock
            $table->timestamps();

            $table->unique(['barang_id', 'gudang_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
