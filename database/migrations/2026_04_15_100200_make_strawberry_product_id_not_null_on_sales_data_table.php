<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Upaya backfill terakhir berdasarkan nama produk (case-insensitive)
        DB::statement("
            UPDATE sales_data sd
            JOIN strawberry_products sp
              ON LOWER(TRIM(sd.nama_produk)) = LOWER(TRIM(sp.name))
            SET sd.strawberry_product_id = sp.id
            WHERE sd.strawberry_product_id IS NULL
        ");

        // Pastikan tidak ada baris yatim piatu sebelum NOT NULL
        $orphanCount = DB::table('sales_data')
            ->whereNull('strawberry_product_id')
            ->count();

        if ($orphanCount > 0) {
            throw new \RuntimeException(
                "Migration dibatalkan: {$orphanCount} baris sales_data tidak punya strawberry_product_id yang cocok. "
                . 'Periksa manual lewat tinker / query, hubungkan ke produk yang tepat atau hapus baris tersebut, '
                . 'lalu jalankan kembali migration ini.'
            );
        }

        // Drop FK dulu karena ON DELETE SET NULL tidak kompatibel dengan NOT NULL
        Schema::table('sales_data', function (Blueprint $table) {
            $table->dropForeign(['strawberry_product_id']);
        });

        Schema::table('sales_data', function (Blueprint $table) {
            $table->foreignId('strawberry_product_id')->nullable(false)->change();
        });

        // Re-add FK dengan RESTRICT supaya produk yang masih punya riwayat penjualan tidak bisa dihapus
        Schema::table('sales_data', function (Blueprint $table) {
            $table->foreign('strawberry_product_id')
                ->references('id')
                ->on('strawberry_products')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sales_data', function (Blueprint $table) {
            $table->dropForeign(['strawberry_product_id']);
        });

        Schema::table('sales_data', function (Blueprint $table) {
            $table->foreignId('strawberry_product_id')->nullable()->change();
        });

        Schema::table('sales_data', function (Blueprint $table) {
            $table->foreign('strawberry_product_id')
                ->references('id')
                ->on('strawberry_products')
                ->nullOnDelete();
        });
    }
};
