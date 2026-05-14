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
        // Membuat tabel 'faqs' untuk menyimpan Frequently Asked Questions
        Schema::create('faqs', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom untuk menyimpan pertanyaan FAQ
            $table->string('question');
            // Kolom untuk menyimpan jawaban FAQ (tipe text untuk panjang lebih fleksibel)
            $table->text('answer');
            // Kolom untuk urutan tampilan FAQ, default 0, dengan komentar untuk dokumentasi
            $table->integer('order')->default(0)->comment('Order for sorting FAQs');
            // Kolom boolean untuk menentukan apakah FAQ aktif/tampil, default true
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
        // Menghapus tabel 'faqs' jika ada, untuk rollback migrasi
        Schema::dropIfExists('faqs');
    }
};
