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
        // Menambahkan kolom 'whatsapp_url' ke tabel 'strawberry_products' untuk link WhatsApp produk
        Schema::table('strawberry_products', function (Blueprint $table) {
            // Kolom untuk URL WhatsApp produk (opsional), ditempatkan setelah kolom 'lazada_url'
            $table->string('whatsapp_url')->nullable()->after('lazada_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom 'whatsapp_url' dari tabel 'strawberry_products' untuk rollback migrasi
        Schema::table('strawberry_products', function (Blueprint $table) {
            $table->dropColumn('whatsapp_url');
        });
    }
};
