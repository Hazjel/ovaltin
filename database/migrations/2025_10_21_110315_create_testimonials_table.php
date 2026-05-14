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
        // Membuat tabel 'testimonials' untuk menyimpan testimonial dari pengguna
        Schema::create('testimonials', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom foreign key ke tabel users, dengan constraint dan cascade delete
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Kolom untuk nama pemberi testimonial
            $table->string('name');
            // Kolom untuk email pemberi testimonial
            $table->string('email');
            // Kolom untuk rating (1-5 bintang), default 5
            $table->integer('rating')->default(5); // 1-5 stars
            // Kolom untuk pesan testimonial
            $table->text('message');
            // Kolom boolean untuk menentukan apakah testimonial disetujui, default false
            $table->boolean('is_approved')->default(false);
            // Kolom timestamps (created_at dan updated_at) otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'testimonials' jika ada, untuk rollback migrasi
        Schema::dropIfExists('testimonials');
    }
};
