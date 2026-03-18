<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StrawberryProduct;

class UpdateProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all existing products to have 'active' status
        StrawberryProduct::whereNull('status')->orWhere('status', '')->update(['status' => 'active']);
        
        // Ensure at least one product exists with active status
        if (StrawberryProduct::where('status', 'active')->count() == 0) {
            StrawberryProduct::create([
                'name' => 'Strawberry Segar Premium',
                'description' => 'Strawberry segar dengan kualitas premium, dipetik langsung dari kebun organik.',
                'price' => 45000,
                'stock_quantity' => 50,
                'category' => 'Buah Segar',
                'origin' => 'Pangalengan, Bandung',
                'harvest_date' => now()->addDays(7),
                'is_organic' => true,
                'nutritional_info' => 'Kaya akan vitamin C dan antioksidan',
                'status' => 'active'
            ]);
        }
        
        $this->command->info('Product statuses updated successfully!');
    }
}