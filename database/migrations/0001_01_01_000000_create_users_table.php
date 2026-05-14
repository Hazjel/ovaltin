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
        // Membuat tabel 'users' untuk menyimpan data pengguna
        Schema::create('users', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom untuk nama pengguna
            $table->string('name');
            // Kolom untuk email pengguna, harus unik
            $table->string('email')->unique();
            // Kolom untuk timestamp verifikasi email (opsional)
            $table->timestamp('email_verified_at')->nullable();
            // Kolom untuk password pengguna (hashed)
            $table->string('password');
            // Kolom untuk remember token (untuk fitur remember me)
            $table->rememberToken();
            // Kolom timestamps (created_at dan updated_at) otomatis
            $table->timestamps();
        });

        // Membuat tabel 'password_reset_tokens' untuk menyimpan token reset password
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // Kolom email sebagai primary key
            $table->string('email')->primary();
            // Kolom untuk token reset password
            $table->string('token');
            // Kolom untuk waktu pembuatan token (opsional)
            $table->timestamp('created_at')->nullable();
        });

        // Membuat tabel 'sessions' untuk menyimpan data sesi pengguna
        Schema::create('sessions', function (Blueprint $table) {
            // Kolom id sesi sebagai primary key
            $table->string('id')->primary();
            // Kolom foreign key ke users (opsional, untuk sesi guest)
            $table->foreignId('user_id')->nullable()->index();
            // Kolom untuk alamat IP pengguna
            $table->string('ip_address', 45)->nullable();
            // Kolom untuk user agent browser
            $table->text('user_agent')->nullable();
            // Kolom untuk payload sesi (data tersimpan)
            $table->longText('payload');
            // Kolom untuk waktu aktivitas terakhir, diindex untuk performa
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'users' jika ada, untuk rollback migrasi
        Schema::dropIfExists('users');
        // Menghapus tabel 'password_reset_tokens' jika ada
        Schema::dropIfExists('password_reset_tokens');
        // Menghapus tabel 'sessions' jika ada
        Schema::dropIfExists('sessions');
    }
};
