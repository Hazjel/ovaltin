<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StrawberryProduct;

class StrawberryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Strawberry Segar Premium',
                'description' => 'Strawberry segar dengan kualitas premium, dipetik langsung dari kebun organik. Rasa manis dan segar yang sempurna untuk konsumsi langsung atau olahan.',
                'price' => 45000,
                'stock_quantity' => 150,
                'category' => 'Fresh Strawberry',
                'image_url' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400',
                'origin' => 'Lembang, Bandung',
                'harvest_date' => now()->subDays(2),
                'quality_grade' => 'Premium',
                'is_organic' => true,
                'nutritional_info' => 'Vitamin C tinggi, antioksidan, serat, dan mineral penting untuk kesehatan tubuh.'
            ],
            [
                'name' => 'Strawberry Frozen Grade A',
                'description' => 'Strawberry beku dengan kualitas Grade A, cocok untuk smoothie, jus, atau campuran dessert. Dibekukan segera setelah panen untuk menjaga kesegaran.',
                'price' => 35000,
                'stock_quantity' => 200,
                'category' => 'Frozen Strawberry',
                'image_url' => 'https://images.unsplash.com/photo-1570197788417-0e82375c9371?w=400',
                'origin' => 'Ciwidey, Bandung',
                'harvest_date' => now()->subDays(5),
                'quality_grade' => 'Grade A',
                'is_organic' => false,
                'nutritional_info' => 'Mengandung vitamin C, folat, dan antioksidan yang baik untuk sistem imun.'
            ],
            [
                'name' => 'Selai Strawberry Homemade',
                'description' => 'Selai strawberry buatan rumahan dengan rasa autentik dan tekstur yang sempurna. Tanpa pengawet buatan, cocok untuk roti, pancake, atau wafel.',
                'price' => 25000,
                'stock_quantity' => 80,
                'category' => 'Strawberry Jam',
                'image_url' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=400',
                'origin' => 'Puncak, Bogor',
                'harvest_date' => now()->subDays(7),
                'quality_grade' => 'Grade A',
                'is_organic' => true,
                'nutritional_info' => 'Kaya akan vitamin C dan antioksidan, rendah kalori, bebas pengawet kimia.'
            ],
            [
                'name' => 'Jus Strawberry Segar',
                'description' => 'Jus strawberry segar tanpa tambahan gula, dibuat dari strawberry pilihan. Rasa alami yang menyegarkan dan menyehatkan.',
                'price' => 18000,
                'stock_quantity' => 120,
                'category' => 'Strawberry Juice',
                'image_url' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=400',
                'origin' => 'Malang, Jawa Timur',
                'harvest_date' => now()->subDays(1),
                'quality_grade' => 'Grade A',
                'is_organic' => true,
                'nutritional_info' => '100% jus alami, kaya vitamin C, antioksidan, dan mineral untuk kesehatan optimal.'
            ],
            [
                'name' => 'Strawberry Dessert Box',
                'description' => 'Dessert box dengan strawberry segar, cream, dan sponge cake. Perpaduan sempurna antara manis dan asam yang menggugah selera.',
                'price' => 55000,
                'stock_quantity' => 25,
                'category' => 'Strawberry Dessert',
                'image_url' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400',
                'origin' => 'Jakarta',
                'harvest_date' => now()->subDays(1),
                'quality_grade' => 'Premium',
                'is_organic' => false,
                'nutritional_info' => 'Mengandung karbohidrat, protein, vitamin C, dan kalsium dari bahan-bahan berkualitas.'
            ],
            [
                'name' => 'Strawberry Organik Grade B',
                'description' => 'Strawberry organik dengan kualitas Grade B, cocok untuk olahan atau konsumsi langsung. Harga terjangkau dengan kualitas yang tetap baik.',
                'price' => 28000,
                'stock_quantity' => 5,
                'category' => 'Fresh Strawberry',
                'image_url' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400',
                'origin' => 'Garut, Jawa Barat',
                'harvest_date' => now()->subDays(3),
                'quality_grade' => 'Grade B',
                'is_organic' => true,
                'nutritional_info' => 'Strawberry organik dengan kandungan nutrisi alami, bebas pestisida kimia.'
            ],
            [
                'name' => 'Strawberry Frozen Grade C',
                'description' => 'Strawberry beku dengan kualitas Grade C, ideal untuk olahan masakan atau campuran smoothie. Harga ekonomis dengan kualitas yang memadai.',
                'price' => 20000,
                'stock_quantity' => 0,
                'category' => 'Frozen Strawberry',
                'image_url' => 'https://images.unsplash.com/photo-1570197788417-0e82375c9371?w=400',
                'origin' => 'Sukabumi, Jawa Barat',
                'harvest_date' => now()->subDays(10),
                'quality_grade' => 'Grade C',
                'is_organic' => false,
                'nutritional_info' => 'Mengandung vitamin C dan serat, cocok untuk olahan makanan dan minuman.'
            ]
        ];

        foreach ($products as $product) {
            StrawberryProduct::create($product);
        }
    }
}
