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
        // Menambahkan kolom 'image' ke tabel 'strawberry_products' untuk menyimpan path gambar produk
        Schema::table('strawberry_products', function (Blueprint $table) {
            // Kolom untuk path gambar produk (opsional), ditempatkan setelah kolom 'category'
            $table->string('image')->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom 'image' dari tabel 'strawberry_products' untuk rollback migrasi
        Schema::table('strawberry_products', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
