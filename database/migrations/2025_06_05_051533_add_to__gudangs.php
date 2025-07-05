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
        Schema::table('gudangs', function (Blueprint $table) {
            // Set default value 'true' (atau 1) untuk kolom 'Aktif'
            $table->boolean('Aktif')->default(true)->change(); // Sesuaikan 'true' dengan nilai default yang Anda inginkan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gudangs', function (Blueprint $table) {
            // Untuk rollback, hapus default value
            $table->boolean('Aktif')->default(null)->change(); // Mengembalikan default ke null
        });
        
    }
};
