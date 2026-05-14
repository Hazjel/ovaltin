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
        // Menambahkan kolom link marketplace ke tabel 'strawberry_products' untuk integrasi e-commerce
        Schema::table('strawberry_products', function (Blueprint $table) {
            // Kolom untuk URL produk di Tokopedia (opsional), ditempatkan setelah kolom 'status'
            $table->string('tokopedia_url')->nullable()->after('status');
            // Kolom untuk URL produk di Shopee (opsional), ditempatkan setelah kolom 'tokopedia_url'
            $table->string('shopee_url')->nullable()->after('tokopedia_url');
            // Kolom untuk URL produk di Lazada (opsional), ditempatkan setelah kolom 'shopee_url'
            $table->string('lazada_url')->nullable()->after('shopee_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom link marketplace dari tabel 'strawberry_products' untuk rollback migrasi
        Schema::table('strawberry_products', function (Blueprint $table) {
            $table->dropColumn(['tokopedia_url', 'shopee_url', 'lazada_url']);
        });
    }
};
