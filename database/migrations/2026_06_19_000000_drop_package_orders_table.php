<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('package_orders');
    }

    public function down(): void
    {
        // Feature removed permanently — no rollback restores the old schema.
    }
};
