<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInfo::create([
            'company_name' => 'Ovaltin',
            'address' => "Desa Lebakmuncang, Kabupaten Bandung, Jawa Barat, Indonesia",
            'phone_primary' => '+62 856-0345-4924',
            'phone_secondary' => '+62 856-0345-4924',
            'email_primary' => 'info@ovaltin.com',
            'email_secondary' => 'order@ovaltin.com',
            'whatsapp' => '+62 856-0345-4924',
            'business_hours' => json_encode([
                'monday_friday' => '08:00 - 17:00',
                'saturday' => '08:00 - 15:00',
                'sunday' => '09:00 - 14:00'
            ]),
            'map_embed_url' => 'https://maps.google.com/maps?q=-7.114057,107.422775&hl=id&z=17&output=embed',
            'description' => 'Ada pertanyaan tentang produk strawberry kami? Ingin memesan dalam jumlah besar? Jangan ragu untuk menghubungi tim Ovaltin!',
            'is_active' => true
        ]);

        $this->command->info('Contact info seeded successfully!');
    }
}