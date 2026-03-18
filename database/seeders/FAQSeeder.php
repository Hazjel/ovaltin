<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa saja jenis strawberry yang tersedia?',
                'answer' => 'Kami menyediakan berbagai jenis strawberry berkualitas tinggi, termasuk strawberry organik dan strawberry premium. Semua produk kami dipetik langsung dari kebun dengan kualitas terbaik.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara memesan produk strawberry?',
                'answer' => 'Anda dapat memesan produk strawberry kami melalui halaman produk. Pilih produk yang diinginkan, tentukan jumlah, dan hubungi kami melalui kontak yang tersedia. Tim kami akan segera merespons pesanan Anda.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah produk strawberry dijamin segar?',
                'answer' => 'Ya, kami menjamin kesegaran produk strawberry kami. Semua produk dipetik langsung dari kebun saat matang sempurna dan dikirim dalam kondisi terbaik. Kami menggunakan metode pengemasan khusus untuk menjaga kesegaran selama pengiriman.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa lama waktu pengiriman?',
                'answer' => 'Waktu pengiriman bervariasi tergantung lokasi tujuan. Untuk area Bandung dan sekitarnya, pengiriman biasanya memakan waktu 1-2 hari kerja. Untuk area yang lebih jauh, waktu pengiriman akan disesuaikan dengan jasa pengiriman yang digunakan.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah produk strawberry organik?',
                'answer' => 'Ya, kami menggunakan metode pertanian organik untuk menghasilkan strawberry berkualitas tinggi. Kami tidak menggunakan pestisida kimia berbahaya dan fokus pada perawatan alami untuk memastikan produk yang sehat dan aman dikonsumsi.',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara menyimpan strawberry agar tetap segar?',
                'answer' => 'Untuk menjaga kesegaran strawberry, simpan di dalam kulkas pada suhu 0-5°C. Jangan cuci strawberry sebelum disimpan, cukup cuci saat akan dikonsumsi. Strawberry sebaiknya dikonsumsi dalam 3-5 hari setelah diterima untuk kualitas terbaik.',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah tersedia pengiriman ke luar kota?',
                'answer' => 'Ya, kami melayani pengiriman ke berbagai kota di Indonesia. Biaya dan waktu pengiriman akan disesuaikan dengan lokasi tujuan. Silakan hubungi kami untuk informasi lebih lanjut mengenai pengiriman ke kota Anda.',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara membayar pesanan?',
                'answer' => 'Kami menerima berbagai metode pembayaran, termasuk transfer bank, e-wallet, dan pembayaran tunai saat pengambilan. Detail pembayaran akan dikirimkan setelah konfirmasi pesanan Anda.',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada minimum order?',
                'answer' => 'Untuk memastikan kualitas dan efisiensi pengiriman, kami memiliki minimum order tertentu. Silakan hubungi kami untuk informasi detail mengenai minimum order dan penawaran khusus untuk pembelian dalam jumlah besar.',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana jika produk yang diterima tidak sesuai atau rusak?',
                'answer' => 'Kami menjamin kualitas produk yang kami kirim. Jika produk yang diterima tidak sesuai atau rusak, silakan hubungi kami segera dengan menyertakan foto produk. Kami akan mengganti produk atau mengembalikan uang sesuai kebijakan kami.',
                'order' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::create($faq);
        }
    }
}
