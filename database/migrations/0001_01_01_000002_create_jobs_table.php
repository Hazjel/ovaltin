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
        // Membuat tabel 'jobs' untuk menyimpan job queue yang akan diproses
        Schema::create('jobs', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom 'queue' untuk nama queue, diindex untuk performa
            $table->string('queue')->index();
            // Kolom 'payload' untuk menyimpan data job dalam format serialized
            $table->longText('payload');
            // Kolom 'attempts' untuk jumlah percobaan eksekusi job
            $table->unsignedTinyInteger('attempts');
            // Kolom 'reserved_at' untuk timestamp kapan job di-reserve oleh worker (opsional)
            $table->unsignedInteger('reserved_at')->nullable();
            // Kolom 'available_at' untuk timestamp kapan job tersedia untuk dieksekusi
            $table->unsignedInteger('available_at');
            // Kolom 'created_at' untuk timestamp pembuatan job
            $table->unsignedInteger('created_at');
        });

        // Membuat tabel 'job_batches' untuk menyimpan batch job
        Schema::create('job_batches', function (Blueprint $table) {
            // Kolom 'id' sebagai primary key
            $table->string('id')->primary();
            // Kolom 'name' untuk nama batch
            $table->string('name');
            // Kolom 'total_jobs' untuk total job dalam batch
            $table->integer('total_jobs');
            // Kolom 'pending_jobs' untuk jumlah job yang masih pending
            $table->integer('pending_jobs');
            // Kolom 'failed_jobs' untuk jumlah job yang gagal
            $table->integer('failed_jobs');
            // Kolom 'failed_job_ids' untuk menyimpan ID job yang gagal
            $table->longText('failed_job_ids');
            // Kolom 'options' untuk opsi batch (opsional)
            $table->mediumText('options')->nullable();
            // Kolom 'cancelled_at' untuk timestamp pembatalan batch (opsional)
            $table->integer('cancelled_at')->nullable();
            // Kolom 'created_at' untuk timestamp pembuatan batch
            $table->integer('created_at');
            // Kolom 'finished_at' untuk timestamp penyelesaian batch (opsional)
            $table->integer('finished_at')->nullable();
        });

        // Membuat tabel 'failed_jobs' untuk menyimpan job yang gagal dieksekusi
        Schema::create('failed_jobs', function (Blueprint $table) {
            // Kolom primary key auto-increment
            $table->id();
            // Kolom 'uuid' untuk unique identifier job yang gagal
            $table->string('uuid')->unique();
            // Kolom 'connection' untuk nama koneksi queue
            $table->text('connection');
            // Kolom 'queue' untuk nama queue
            $table->text('queue');
            // Kolom 'payload' untuk data job yang gagal
            $table->longText('payload');
            // Kolom 'exception' untuk pesan error/exception
            $table->longText('exception');
            // Kolom 'failed_at' untuk timestamp kegagalan, default current timestamp
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'jobs' jika ada, untuk rollback migrasi
        Schema::dropIfExists('jobs');
        // Menghapus tabel 'job_batches' jika ada
        Schema::dropIfExists('job_batches');
        // Menghapus tabel 'failed_jobs' jika ada
        Schema::dropIfExists('failed_jobs');
    }
};
