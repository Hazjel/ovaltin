@extends('layouts.app')

@section('title', 'Stroberi sebagai Alternatif Camilan Sehat untuk Anak dan Remaja')

@section('content')
<div class="max-w-screen-xl mx-auto space-y-10 px-4 sm:px-6 lg:px-8 pb-16">
    <header class="relative overflow-hidden rounded-3xl bg-white text-slate-900 shadow-xl mt-10 border border-slate-100">
        <div class="absolute inset-0 bg-gradient-to-br from-pink-50 via-white to-pink-50"></div>
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute -left-10 -top-10 w-60 h-60 bg-pink-100 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute -right-16 bottom-0 w-72 h-72 bg-pink-100 rounded-full blur-3xl opacity-60"></div>
        </div>
        <div class="relative grid lg:grid-cols-2 gap-10 p-10 items-center">
            <div class="space-y-4">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-pink-100 text-pink-700 text-xs font-semibold uppercase tracking-wide border border-pink-200">
                    Artikel Edukasi
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold leading-tight">
                    Stroberi sebagai Alternatif Camilan Sehat untuk Anak dan Remaja
                </h1>
                <p class="text-slate-700 leading-relaxed max-w-2xl">
                    Di tengah banyaknya pilihan camilan instan, stroberi hadir sebagai solusi sehat, lezat,
                    dan kaya nutrisi untuk anak dan remaja aktif.
                </p>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Vitamin C tinggi
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Kaya antioksidan
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                        Serat alami
                    </span>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rounded-3xl bg-pink-200/40 blur-3xl"></div>
                <img src="{{ asset('images/foto logo.webp') }}"
                     alt="Produk Dapur Ovaltin"
                     class="relative rounded-2xl shadow-2xl border border-slate-100 w-full h-full object-cover">
            </div>
        </div>
    </header>

    <div class="bg-gradient-to-b from-slate-50 via-white to-slate-50 rounded-3xl shadow-inner border border-slate-100 p-6 md:p-10 space-y-8">
        <div class="grid lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-8">
                <section class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Ringkasan Cepat</h2>
                            <p class="text-slate-600 text-sm mt-1">Tiga alasan stroberi cocok sebagai camilan sehat.</p>
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-pink-50 text-pink-700 text-sm font-semibold border border-pink-100">
                            Nutrisi lengkap
                        </div>
                    </div>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-pink-800 mb-2">Vitamin C</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Membantu daya tahan tubuh, penyembuhan luka, dan mendukung tumbuh kembang optimal.
                            </p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-pink-800 mb-2">Antioksidan</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Antosianin dan flavonoid melindungi sel tubuh dari kerusakan akibat radikal bebas.
                            </p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-emerald-800 mb-2">Serat</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Baik untuk pencernaan dan memberikan rasa kenyang lebih lama.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8 space-y-6">
                    <h2 class="text-2xl font-bold text-slate-900">Isi Artikel</h2>
                    <div class="space-y-5 text-slate-700 leading-relaxed">
                        <p>
                            Di tengah banyaknya pilihan camilan instan dengan bahan tambahan pangan, orang tua perlu lebih
                            selektif dalam memilih makanan ringan untuk anak dan remaja. Salah satu pilihan camilan sehat
                            dan disukai berbagai kalangan adalah stroberi. Buah berwarna merah cerah ini tidak hanya
                            memiliki rasa manis dan segar, tetapi juga kaya akan berbagai nutrisi yang bermanfaat bagi
                            kesehatan.
                        </p>
                        <p>
                            Stroberi mengandung vitamin C yang tinggi, bahkan dalam jumlah yang dapat membantu memenuhi
                            kebutuhan harian anak dan remaja. Vitamin C berperan penting dalam menjaga daya tahan tubuh,
                            membantu proses penyembuhan luka, serta mendukung pertumbuhan dan perkembangan yang optimal.
                            Selain itu, stroberi juga mengandung serat yang baik untuk kesehatan pencernaan dan membantu
                            memberikan rasa kenyang lebih lama.
                        </p>
                        <p>
                            Kandungan antioksidan dalam stroberi, seperti antosianin dan flavonoid, juga berperan dalam
                            melindungi sel-sel tubuh dari kerusakan akibat radikal bebas. Bagi anak dan remaja yang aktif
                            beraktivitas, konsumsi buah-buahan kaya antioksidan dapat membantu menjaga kesehatan tubuh
                            secara keseluruhan.
                        </p>
                        <p>
                            Salah satu keunggulan stroberi sebagai camilan adalah fleksibilitas dalam penyajiannya. Buah
                            ini dapat dinikmati secara langsung setelah dicuci bersih, dicampurkan ke dalam yogurt,
                            dijadikan smoothie, atau diolah menjadi berbagai produk sehat seperti keripik stroberi, selai,
                            dan granola buah. Dengan penyajian yang menarik, anak-anak cenderung lebih mudah menyukai
                            dan mengonsumsi buah secara rutin.
                        </p>
                        <p>
                            Bagi pelaku UMKM, stroberi juga memiliki potensi besar untuk dikembangkan menjadi produk olahan
                            bernilai tambah. Inovasi produk berbahan dasar stroberi dapat menjadi peluang usaha yang
                            menjanjikan sekaligus mendukung pola konsumsi makanan sehat di masyarakat.
                        </p>
                        <p>
                            Dengan kandungan gizi yang melimpah, rasa yang lezat, serta berbagai pilihan olahan yang menarik,
                            stroberi merupakan alternatif camilan sehat yang sangat cocok untuk anak dan remaja. Mengonsumsi
                            stroberi secara rutin dapat menjadi langkah sederhana untuk membangun kebiasaan hidup sehat
                            sejak usia dini.
                        </p>
                    </div>
                </section>
            </div>

            <aside class="lg:col-span-4 space-y-6">
                <div class="rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 text-white shadow-xl p-6 border border-white/10">
                    <h3 class="text-lg font-semibold mb-3">Manfaat Stroberi</h3>
                    <ul class="space-y-2 text-pink-50 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80 flex-shrink-0"></span>
                            Vitamin C tinggi untuk imunitas.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80 flex-shrink-0"></span>
                            Serat baik untuk pencernaan.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80 flex-shrink-0"></span>
                            Antioksidan melindungi sel tubuh.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80 flex-shrink-0"></span>
                            Rendah kalori, cocok untuk diet sehat.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80 flex-shrink-0"></span>
                            Fleksibel diolah menjadi berbagai produk.
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">Produk Ovaltin</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Dapur Ovaltin menghadirkan produk olahan stroberi berkualitas untuk mendukung
                        pola hidup sehat Anda dan keluarga.
                    </p>
                    <a href="{{ route('strawberry-products.index') }}"
                       class="inline-flex items-center px-4 py-2 rounded-full bg-pink-600 text-white text-sm font-semibold hover:bg-pink-700 transition-colors">
                        Lihat Produk Kami
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
