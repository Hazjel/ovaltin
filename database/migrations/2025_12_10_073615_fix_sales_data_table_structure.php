<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menghapus tabel 'sales_data' jika ada untuk membuat ulang dengan struktur yang benar
        Schema::dropIfExists('sales_data');
        
        // Membuat ulang tabel 'sales_data' untuk menyimpan data penjualan produk stroberi
        Schema::create('sales_data', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom untuk tanggal penjualan
            $table->date('tanggal_penjualan');
            // Kolom untuk nama produk (seperti Agar, Dodol, Krupuk, Selai)
            $table->string('nama_produk'); // Agar, Dodol, Krupuk, Selai
            // Kolom untuk jumlah produk yang terjual, default 0
            $table->integer('jumlah_terjual')->default(0);
            // Kolom timestamps (created_at dan updated_at) otomatis
            $table->timestamps();
            
            // Index pada kolom tanggal_penjualan untuk performa query berdasarkan tanggal
            $table->index('tanggal_penjualan');
            // Index pada kolom nama_produk untuk performa query berdasarkan nama produk
            $table->index('nama_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'sales_data' jika ada, untuk rollback migrasi
        Schema::dropIfExists('sales_data');
    }
};
