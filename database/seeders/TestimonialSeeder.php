<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\User;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@email.com',
                'rating' => 5,
                'message' => 'Strawberry dari kebun ini benar-benar segar dan manis! Kualitasnya premium dan harganya sangat terjangkau. Keluarga saya sangat menyukainya. Pasti akan memesan lagi!',
            ],
            [
                'name' => 'Ahmad Rahman',
                'email' => 'ahmad.rahman@email.com',
                'rating' => 5,
                'message' => 'Pengalaman belanja strawberry yang luar biasa! Produk organik dengan rasa yang autentik. Pelayanan customer service juga sangat ramah dan responsif. Highly recommended!',
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@email.com',
                'rating' => 4,
                'message' => 'Strawberry frozen Grade A sangat cocok untuk smoothie saya. Tekstur dan rasa tetap terjaga meskipun sudah dibekukan. Pengiriman cepat dan kemasan rapi.',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'rating' => 5,
                'message' => 'Selai strawberry homemade-nya enak banget! Tidak terlalu manis dan teksturnya pas. Cocok untuk roti panggang dan pancake. Produk lokal yang berkualitas internasional!',
            ],
            [
                'name' => 'Lisa Chen',
                'email' => 'lisa.chen@email.com',
                'rating' => 5,
                'message' => 'Jus strawberry segar tanpa gula tambahan sangat menyegarkan! Rasa alami yang tidak terlalu asam. Perfect untuk sarapan sehat. Akan menjadi pelanggan tetap!',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@email.com',
                'rating' => 4,
                'message' => 'Strawberry dessert box-nya sangat lezat! Kombinasi strawberry segar, cream, dan sponge cake yang sempurna. Cocok untuk acara spesial atau hadiah.',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'rating' => 5,
                'message' => 'Strawberry organik Grade B dengan harga yang sangat terjangkau! Meskipun Grade B, kualitasnya tetap bagus untuk konsumsi sehari-hari. Value for money!',
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'rating' => 4,
                'message' => 'Strawberry frozen Grade C cocok untuk campuran smoothie dan baking. Harga ekonomis dengan kualitas yang memadai. Pengiriman tepat waktu dan kemasan aman.',
            ],
        ];

        // Get first user or create a demo user
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);
        }

        foreach ($testimonials as $testimonial) {
            Testimonial::create([
                'user_id' => $user->id,
                'name' => $testimonial['name'],
                'email' => $testimonial['email'],
                'rating' => $testimonial['rating'],
                'message' => $testimonial['message'],
                'is_approved' => true, // Semua testimoni langsung disetujui
            ]);
        }
    }
}