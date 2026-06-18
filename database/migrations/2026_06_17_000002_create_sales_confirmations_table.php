<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_confirmations', function (Blueprint $table) {
            $table->id();
            $table->date('confirmation_date'); // tanggal konfirmasi
            $table->boolean('has_sales');      // true = ada penjualan, false = tidak ada
            $table->string('week_key');        // format: "2026-W25" untuk identifikasi minggu
            $table->timestamps();

            $table->unique('confirmation_date'); // satu konfirmasi per hari
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_confirmations');
    }
};
