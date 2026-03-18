<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sales_data', 'strawberry_product_id')) {
            Schema::table('sales_data', function (Blueprint $table) {
                $table->foreignId('strawberry_product_id')
                    ->nullable()
                    ->after('tanggal_penjualan')
                    ->constrained('strawberry_products')
                    ->nullOnDelete();

                $table->index('strawberry_product_id');
            });
        }

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
        if (Schema::hasColumn('sales_data', 'strawberry_product_id')) {
            Schema::table('sales_data', function (Blueprint $table) {
                $table->dropForeign(['strawberry_product_id']);
                $table->dropIndex(['strawberry_product_id']);
                $table->dropColumn('strawberry_product_id');
            });
        }
    }
};
