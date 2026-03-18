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
        // Drop tabel jika ada untuk recreate dengan struktur yang benar
        Schema::dropIfExists('sales_data');
        
        Schema::create('sales_data', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_penjualan');
            $table->string('nama_produk'); // Agar, Dodol, Krupuk, Selai
            $table->integer('jumlah_terjual')->default(0);
            $table->timestamps();
            
            $table->index('tanggal_penjualan');
            $table->index('nama_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_data');
    }
};
