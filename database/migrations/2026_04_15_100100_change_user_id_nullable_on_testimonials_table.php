<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah kolom 'user_id' di tabel 'testimonials' menjadi nullable (opsional)
        // Langkah 1: Hapus foreign key constraint yang ada
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // Langkah 2: Ubah kolom 'user_id' menjadi nullable
        Schema::table('testimonials', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
        });

        // Langkah 3: Tambahkan kembali foreign key constraint dengan null on delete
        Schema::table('testimonials', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Mengembalikan kolom 'user_id' di tabel 'testimonials' menjadi NOT NULL (rollback)
        // Langkah 1: Hapus foreign key constraint yang ada
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // Langkah 2: Ubah kolom 'user_id' menjadi NOT NULL
        Schema::table('testimonials', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });

        // Langkah 3: Tambahkan kembali foreign key constraint dengan cascade on delete
        Schema::table('testimonials', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }
};
