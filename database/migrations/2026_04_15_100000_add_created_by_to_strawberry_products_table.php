<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan kolom 'created_by' ke tabel 'strawberry_products' untuk melacak siapa yang membuat produk
        Schema::table('strawberry_products', function (Blueprint $table) {
            // Kolom foreign key ke tabel 'users', nullable, dengan constraint dan null on delete
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Menghapus kolom 'created_by' dari tabel 'strawberry_products' untuk rollback migrasi
        Schema::table('strawberry_products', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['created_by']);
            // Menghapus kolom
            $table->dropColumn('created_by');
        });
    }
};
