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
        // Menambahkan kolom untuk reply testimonial ke tabel 'testimonials'
        Schema::table('testimonials', function (Blueprint $table) {
            // Kolom untuk teks reply (opsional), ditempatkan setelah kolom 'message'
            $table->text('reply')->nullable()->after('message');
            // Kolom untuk timestamp kapan reply dibuat (opsional), ditempatkan setelah kolom 'reply'
            $table->timestamp('replied_at')->nullable()->after('reply');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus kolom reply dari tabel 'testimonials' untuk rollback migrasi
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['reply', 'replied_at']);
        });
    }
};
