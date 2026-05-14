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
        // Membuat tabel 'contact_infos' untuk menyimpan informasi kontak perusahaan
        Schema::create('contact_infos', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom untuk nama perusahaan, default 'Ovaltin'
            $table->string('company_name')->default('Ovaltin');
            // Kolom untuk alamat perusahaan (opsional)
            $table->text('address')->nullable();
            // Kolom untuk nomor telepon utama (opsional)
            $table->string('phone_primary')->nullable();
            // Kolom untuk nomor telepon sekunder (opsional)
            $table->string('phone_secondary')->nullable();
            // Kolom untuk email utama (opsional)
            $table->string('email_primary')->nullable();
            // Kolom untuk email sekunder (opsional)
            $table->string('email_secondary')->nullable();
            // Kolom untuk nomor WhatsApp (opsional)
            $table->string('whatsapp')->nullable();
            // Kolom untuk jam operasional bisnis (opsional)
            $table->text('business_hours')->nullable();
            // Kolom untuk URL embed peta (opsional)
            $table->string('map_embed_url')->nullable();
            // Kolom untuk deskripsi tambahan (opsional)
            $table->text('description')->nullable();
            // Kolom boolean untuk menentukan apakah info kontak aktif, default true
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
        // Menghapus tabel 'contact_infos' jika ada, untuk rollback migrasi
        Schema::dropIfExists('contact_infos');
    }
};
