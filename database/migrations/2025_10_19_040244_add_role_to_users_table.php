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
        // Menambahkan kolom 'role' ke tabel 'users' untuk membedakan role pengguna
        Schema::table('users', function (Blueprint $table) {
            // Kolom enum untuk role pengguna, hanya bisa 'user' atau 'admin', default 'user', ditempatkan setelah kolom 'email'
            $table->enum('role', ['user', 'admin'])->default('user')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom 'role' dari tabel 'users' untuk rollback migrasi
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
