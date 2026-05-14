<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Memastikan kolom 'strawberry_product_id' ada di tabel 'sales_data', jika belum ada maka tambahkan
        if (!Schema::hasColumn('sales_data', 'strawberry_product_id')) {
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
        }

        // Jika kolom 'strawberry_product_id' sudah ada, lakukan backfill untuk mengisi data yang kosong
        if (Schema::hasColumn('sales_data', 'strawberry_product_id')) {
            DB::statement("
                UPDATE sales_data sd
                JOIN strawberry_products sp
                  ON LOWER(TRIM(sd.nama_produk)) = LOWER(TRIM(sp.name))
                SET sd.strawberry_product_id = sp.id
                WHERE sd.strawberry_product_id IS NULL
            ");
        }
    }

    public function down(): void
    {
        // Jika kolom 'strawberry_product_id' ada, hapus untuk rollback migrasi
        if (Schema::hasColumn('sales_data', 'strawberry_product_id')) {
            Schema::table('sales_data', function (Blueprint $table) {
                // Menghapus foreign key constraint
                $table->dropForeign(['strawberry_product_id']);
                // Menghapus index
                $table->dropIndex(['strawberry_product_id']);
                // Menghapus kolom
                $table->dropColumn('strawberry_product_id');
            });
        }
    }
};
