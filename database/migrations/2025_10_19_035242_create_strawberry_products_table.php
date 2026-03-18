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
        Schema::create('strawberry_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity');
            $table->string('category');
            $table->string('image_url')->nullable();
            $table->string('origin');
            $table->date('harvest_date');
            $table->enum('quality_grade', ['Premium', 'Grade A', 'Grade B', 'Grade C']);
            $table->boolean('is_organic')->default(false);
            $table->text('nutritional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strawberry_products');
    }
};
