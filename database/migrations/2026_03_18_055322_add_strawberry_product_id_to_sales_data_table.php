<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan kolom foreign key 'strawberry_product_id' ke tabel 'sales_data' untuk relasi ke produk stroberi
        Schema::table('sales_data', function (Blueprint $table) {
            // Kolom foreign key ke tabel 'strawberry_products', nullable, ditempatkan setelah 'tanggal_penjualan', dengan constraint dan null on delete
            $table->foreignId('strawberry_product_id')
                ->nullable()
                ->after('tanggal_penjualan')
                ->constrained('strawberry_products')
                ->nullOnDelete();

            // Index pada kolom 'strawberry_product_id' untuk performa query
            $table->index('strawberry_product_id');
        });

        // Backfill: mencocokkan nama produk lama ke ID produk (case-insensitive) untuk mengisi data yang ada
        DB::statement("
            UPDATE sales_data sd
            JOIN strawberry_products sp
              ON LOWER(TRIM(sd.nama_produk)) = LOWER(TRIM(sp.name))
            SET sd.strawberry_product_id = sp.id
            WHERE sd.strawberry_product_id IS NULL
        ");
    }

    public function down(): void
    {
        // Menghapus kolom 'strawberry_product_id' dari tabel 'sales_data' untuk rollback migrasi
        Schema::table('sales_data', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['strawberry_product_id']);
            // Menghapus index
            $table->dropIndex(['strawberry_product_id']);
            // Menghapus kolom
            $table->dropColumn('strawberry_product_id');
        });
    }
};
