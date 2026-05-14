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
        // Menambahkan kolom 'status' ke tabel 'strawberry_products' untuk menentukan status produk
        Schema::table('strawberry_products', function (Blueprint $table) {
            // Kolom enum untuk status produk, bisa 'active', 'inactive', atau 'out_of_stock', default 'active', ditempatkan setelah kolom 'is_organic'
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active')->after('is_organic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom 'status' dari tabel 'strawberry_products' untuk rollback migrasi
        Schema::table('strawberry_products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};