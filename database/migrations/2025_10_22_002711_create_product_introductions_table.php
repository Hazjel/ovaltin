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
        // Membuat tabel 'product_introductions' untuk menyimpan informasi pengenalan produk
        Schema::create('product_introductions', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom untuk judul pengenalan produk
            $table->string('title');
            // Kolom untuk deskripsi singkat produk
            $table->text('description');
            // Kolom untuk konten lengkap pengenalan produk
            $table->text('content');
            // Kolom untuk judul fitur pertama (opsional)
            $table->string('feature_1_title')->nullable();
            // Kolom untuk deskripsi fitur pertama (opsional)
            $table->text('feature_1_description')->nullable();
            // Kolom untuk judul fitur kedua (opsional)
            $table->string('feature_2_title')->nullable();
            // Kolom untuk deskripsi fitur kedua (opsional)
            $table->text('feature_2_description')->nullable();
            // Kolom untuk path gambar produk (opsional)
            $table->string('image_path')->nullable();
            // Kolom boolean untuk menentukan apakah pengenalan aktif/tampil, default true
            $table->boolean('is_active')->default(true);
            // Kolom timestamps (created_at dan updated_at) otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'product_introductions' jika ada, untuk rollback migrasi
        Schema::dropIfExists('product_introductions');
    }
};
