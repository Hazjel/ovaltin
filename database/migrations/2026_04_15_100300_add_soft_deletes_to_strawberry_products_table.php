<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan soft deletes ke tabel 'strawberry_products' untuk menghapus data secara lunak (tidak benar-benar dihapus dari database)
        Schema::table('strawberry_products', function (Blueprint $table) {
            // Menambahkan kolom 'deleted_at' untuk soft deletes
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        // Menghapus soft deletes dari tabel 'strawberry_products' untuk rollback migrasi
        Schema::table('strawberry_products', function (Blueprint $table) {
            // Menghapus kolom 'deleted_at'
            $table->dropSoftDeletes();
        });
    }
};
