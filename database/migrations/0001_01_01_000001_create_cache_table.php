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
        // Membuat tabel 'cache' untuk menyimpan data cache aplikasi
        Schema::create('cache', function (Blueprint $table) {
            // Kolom 'key' sebagai primary key untuk identifikasi cache
            $table->string('key')->primary();
            // Kolom 'value' untuk menyimpan data cache (tipe mediumText untuk kapasitas lebih besar)
            $table->mediumText('value');
            // Kolom 'expiration' untuk menyimpan waktu kadaluarsa cache dalam timestamp
            $table->integer('expiration');
        });

        // Membuat tabel 'cache_locks' untuk menyimpan lock cache untuk mencegah race condition
        Schema::create('cache_locks', function (Blueprint $table) {
            // Kolom 'key' sebagai primary key untuk identifikasi lock
            $table->string('key')->primary();
            // Kolom 'owner' untuk menyimpan identifier pemilik lock
            $table->string('owner');
            // Kolom 'expiration' untuk menyimpan waktu kadaluarsa lock dalam timestamp
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'cache' jika ada, untuk rollback migrasi
        Schema::dropIfExists('cache');
        // Menghapus tabel 'cache_locks' jika ada
        Schema::dropIfExists('cache_locks');
    }
};
