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
        // Membuat tabel 'strawberry_products' untuk menyimpan data produk stroberi
        Schema::create('strawberry_products', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom untuk nama produk stroberi
            $table->string('name');
            // Kolom untuk deskripsi produk
            $table->text('description');
            // Kolom untuk harga produk (decimal dengan 2 digit desimal)
            $table->decimal('price', 10, 2);
            // Kolom untuk jumlah stok produk
            $table->integer('stock_quantity');
            // Kolom untuk kategori produk
            $table->string('category');
            // Kolom untuk URL gambar produk (opsional)
            $table->string('image_url')->nullable();
            // Kolom untuk asal produk
            $table->string('origin');
            // Kolom untuk tanggal panen produk
            $table->date('harvest_date');
            // Kolom enum untuk grade kualitas produk
            $table->enum('quality_grade', ['Premium', 'Grade A', 'Grade B', 'Grade C']);
            // Kolom boolean untuk menentukan apakah produk organik, default false
            $table->boolean('is_organic')->default(false);
            // Kolom untuk informasi nutrisi produk (opsional)
            $table->text('nutritional_info')->nullable();
            // Kolom timestamps (created_at dan updated_at) otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'strawberry_products' jika ada, untuk rollback migrasi
        Schema::dropIfExists('strawberry_products');
    }
};
