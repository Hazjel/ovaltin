<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address')->nullable();
            $table->json('items'); // [{product_id, product_name, qty, price_per_unit, subtotal}]
            $table->decimal('total_price', 12, 2);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_orders');
    }
};
