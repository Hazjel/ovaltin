<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_phone');
            $table->string('type'); // pagi, malam, test
            $table->text('message');
            $table->string('status'); // sukses, gagal
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
