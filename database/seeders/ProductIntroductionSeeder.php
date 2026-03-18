<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductIntroduction;

class ProductIntroductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductIntroduction::create([
            'title' => 'Strawberry Segar dari Kebun Kami',
            'description' => 'Nikmati strawberry segar berkualitas premium langsung dari kebun kami',
            'content' => 'Kami adalah produsen strawberry premium yang berlokasi di dataran tinggi dengan iklim sempurna untuk menghasilkan strawberry berkualitas terbaik. Setiap buah dipetik dengan hati-hati saat matang sempurna untuk memastikan rasa dan kesegaran yang optimal. Dengan metode pertanian organik dan perawatan yang teliti, kami menghadirkan strawberry yang tidak hanya lezat, tetapi juga sehat dan bergizi tinggi.',
            'feature_1_title' => 'Segar',
            'feature_1_description' => 'Dari Kebun',
            'feature_2_title' => '100%',
            'feature_2_description' => 'Organik Murni',
            'image_path' => null,
            'is_active' => true
        ]);

        $this->command->info('Product introduction seeded successfully!');
    }
}
