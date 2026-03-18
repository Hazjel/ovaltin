@extends('layouts.app')

@section('title', 'Cara Menanam Strawberry dari Bibit')

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
                    Panduan Praktis
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold leading-tight">
                    Cara Menanam Strawberry dari Bibit
                </h1>
                <p class="text-slate-700 leading-relaxed max-w-2xl">
                    Panduan lengkap dari pemilihan bibit hingga penanaman untuk menghasilkan strawberry berkualitas tinggi.
                    Ikuti langkah-langkah terstruktur untuk memastikan tanaman tumbuh optimal.
                </p>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Pemilihan bibit
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Persiapan media
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                        Jarak tanam optimal
                    </span>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rounded-3xl bg-pink-200/40 blur-3xl"></div>
                <img src="{{ asset('images/6622920910034.jpg') }}"
                     alt="Menanam Strawberry"
                     class="relative rounded-2xl shadow-2xl border border-slate-100 w-full h-full object-cover"
                     onerror="this.onerror=null; this.src='{{ asset('images/strawberry-farm.webp') }}';">
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
                            <p class="text-slate-600 text-sm mt-1">Tiga langkah utama untuk menanam strawberry dengan sukses.</p>
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-pink-50 text-pink-700 text-sm font-semibold border border-pink-100">
                            Mode praktis: 3 langkah utama
                        </div>
                    </div>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-pink-800 mb-2">Pemilihan Bibit</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Pilih bibit yang sehat, bebas penyakit, dan memiliki akar yang kuat. Bibit berkualitas menentukan keberhasilan panen.
                            </p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-pink-800 mb-2">Persiapan Media</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Siapkan media tanam dengan pH 5.5-6.5, drainase baik, dan kandungan organik yang cukup untuk pertumbuhan optimal.
                            </p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-emerald-800 mb-2">Jarak Tanam</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Jarak tanam 30-40 cm antar tanaman memastikan sirkulasi udara baik dan mengurangi risiko penyakit.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-pink-100 text-pink-700 font-bold">1</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Pemilihan Bibit</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Pilih bibit strawberry yang sehat dengan ciri-ciri: daun hijau segar tanpa bercak, akar putih dan kuat, 
                                    tidak ada tanda-tanda penyakit atau hama. Pilih varietas yang sesuai dengan iklim lokal. Bibit yang baik 
                                    memiliki 3-4 daun sehat dan sistem akar yang berkembang baik.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-pink-100 text-pink-700 font-bold">2</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Persiapan Media Tanam</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Siapkan media tanam dengan komposisi: tanah gembur, kompos matang, dan pasir dengan perbandingan 2:1:1. 
                                    Pastikan pH tanah antara 5.5-6.5. Jika terlalu asam, tambahkan dolomit. Pastikan drainase baik dengan 
                                    menambahkan sekam padi atau perlite. Media harus lembap tapi tidak basah.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-700 font-bold">3</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Teknik Penanaman</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Buat lubang tanam dengan kedalaman 15-20 cm dan jarak 30-40 cm antar tanaman. Letakkan bibit dengan 
                                    posisi mahkota (crown) tepat di permukaan tanah, tidak terlalu dalam atau terlalu tinggi. Padatkan 
                                    tanah di sekitar bibit dan siram dengan air secukupnya. Beri mulsa organik untuk menjaga kelembapan.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-rose-100 text-rose-700 font-bold">4</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Perawatan Awal</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Setelah penanaman, lakukan penyiraman ringan setiap hari selama 1-2 minggu pertama. Lindungi bibit 
                                    dari sinar matahari langsung dengan naungan sementara. Pantau pertumbuhan dan pastikan tidak ada 
                                    gulma yang mengganggu. Setelah bibit mulai tumbuh aktif, kurangi frekuensi penyiraman.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <aside class="lg:col-span-4 space-y-6">
                <div class="rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 text-white shadow-xl p-6 border border-white/10">
                    <h3 class="text-lg font-semibold mb-3">Kunci Keberhasilan</h3>
                    <ul class="space-y-2 text-pink-50 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Pilih bibit berkualitas dari sumber terpercaya.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Media tanam dengan pH optimal & drainase baik.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Jarak tanam tepat untuk sirkulasi udara.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Perawatan konsisten & monitoring rutin.
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">Sumber Artikel</h3>
                    <ol class="list-decimal list-inside space-y-2 text-slate-700 text-sm">
                        <li>
                            University of California ANR — "Strawberry Planting Guide".
                        </li>
                        <li>
                            Oregon State University Extension — "Growing Strawberries in Your Home Garden".
                        </li>
                        <li>
                            FAO Horticulture Notes — "Strawberry Cultivation Best Practices".
                        </li>
                    </ol>
                    <p class="text-xs text-slate-500 mt-3">
                        Panduan disarikan dari praktik penanaman strawberry dan referensi universitas pertanian terkemuka.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                    <img src="{{ asset('images/6622920910034.jpg') }}"
                         alt="Menanam Strawberry"
                         class="w-full h-64 object-cover"
                         onerror="this.onerror=null; this.src='{{ asset('images/strawberry-farm.webp') }}';">
                </div>
            </aside>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6 md:p-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tips Tambahan</p>
                <h2 class="text-2xl font-bold text-slate-900">Waktu & Kondisi Penanaman Terbaik</h2>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Faktor-faktor penting yang perlu diperhatikan untuk memastikan keberhasilan penanaman strawberry.
                </p>
            </div>
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                Fokus: timing & kondisi optimal
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Waktu Penanaman</h3>
                <ul class="text-sm text-slate-700 space-y-2">
                    <li><strong>Musim hujan:</strong> Tanam di awal musim untuk adaptasi optimal.</li>
                    <li><strong>Pagi hari:</strong> Waktu terbaik untuk mengurangi stress tanaman.</li>
                    <li><strong>Suhu ideal:</strong> 15-25°C untuk pertumbuhan optimal.</li>
                    <li><strong>Hindari:</strong> Penanaman saat cuaca ekstrem atau hujan deras.</li>
                </ul>
            </div>
            <div class="rounded-2xl border border-pink-100 bg-pink-50 p-5">
                <h3 class="text-lg font-semibold text-pink-900 mb-2">Kondisi Lingkungan</h3>
                <ul class="text-sm text-pink-900/80 space-y-2">
                    <li><strong>Sinar matahari:</strong> Minimal 6-8 jam per hari.</li>
                    <li><strong>Kelembapan:</strong> 60-70% untuk pertumbuhan optimal.</li>
                    <li><strong>Angin:</strong> Sirkulasi baik tapi tidak terlalu kencang.</li>
                    <li><strong>Naungan:</strong> Diperlukan saat cuaca sangat panas.</li>
                </ul>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-rose-50 p-5">
                <h3 class="text-lg font-semibold text-rose-900 mb-2">Persiapan Lahan</h3>
                <ul class="text-sm text-rose-900/80 space-y-2">
                    <li><strong>Bedengan:</strong> Tinggi 20-30 cm untuk drainase baik.</li>
                    <li><strong>Gulma:</strong> Bersihkan sebelum penanaman.</li>
                    <li><strong>Pupuk dasar:</strong> Aplikasikan 2-3 minggu sebelum tanam.</li>
                    <li><strong>Mulsa:</strong> Pasang setelah penanaman untuk kelembapan.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

