@extends('layouts.app')

@section('title', 'Pengendalian Hama & Penyakit Strawberry')

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
                    Pengendalian Hama & Penyakit Strawberry
                </h1>
                <p class="text-slate-700 leading-relaxed max-w-2xl">
                    Strategi preventif dan kuratif untuk melindungi tanaman strawberry dari serangan hama dan penyakit,
                    menjaga kualitas buah tetap optimal dan panen berkelanjutan.
                </p>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Pestisida organik
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Monitoring rutin
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                        Higienitas kebun
                    </span>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rounded-3xl bg-pink-200/40 blur-3xl"></div>
                <img src="{{ asset('images/pengendalian-hama.webp') }}"
                     alt="Pengendalian Hama Strawberry"
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
                            <p class="text-slate-600 text-sm mt-1">Tiga pilar utama untuk melindungi tanaman dari hama dan penyakit.</p>
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-pink-50 text-pink-700 text-sm font-semibold border border-pink-100">
                            Mode praktis: 3 pilar utama
                        </div>
                    </div>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-pink-800 mb-2">Sanitasi</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Buang bagian busuk setiap hari, ganti mulsa kotor, dan jaga kebersihan alat panen untuk mencegah penyebaran penyakit.
                            </p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-pink-800 mb-2">Pengendalian Serangga</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Gunakan insektisida nabati (neem) setiap 7–10 hari, pasang perangkap kuning, dan periksa bagian bawah daun secara rutin.
                            </p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-emerald-800 mb-2">Pencegahan Jamur</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Jaga sirkulasi udara, siram pagi hari agar daun cepat kering, dan rotasi bedengan jika ada gejala virus berat.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-pink-100 text-pink-700 font-bold">1</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Sanitasi Kebun</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Kebersihan adalah kunci utama pencegahan. Buang daun dan buah yang busuk setiap hari untuk menekan 
                                    pertumbuhan spora jamur. Ganti mulsa jika sudah kotor atau berjamur. Pastikan semua alat panen 
                                    dicuci bersih sebelum digunakan untuk mencegah kontaminasi silang.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-pink-100 text-pink-700 font-bold">2</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Pengendalian Serangga</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Aplikasikan insektisida nabati berbahan neem dengan dosis ringan setiap 7–10 hari. Pasang perangkap 
                                    kuning di sekitar bedengan untuk menangkap kutu daun dan thrips. Lakukan inspeksi rutin pada bagian 
                                    bawah daun setiap minggu untuk deteksi dini serangan hama.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-700 font-bold">3</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Pencegahan Jamur & Virus</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Pastikan sirkulasi udara baik dengan menjaga jarak tanam yang cukup. Siram tanaman di pagi hari 
                                    agar daun cepat kering sebelum malam. Jika terdeteksi gejala virus atau layu berat, lakukan rotasi 
                                    bedengan dan hindari menanam di lokasi yang sama selama minimal 2 tahun.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-rose-100 text-rose-700 font-bold">4</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Monitoring & Deteksi Dini</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Lakukan pemeriksaan visual harian pada tanaman untuk mendeteksi gejala awal penyakit atau serangan hama. 
                                    Catat perubahan warna daun, bercak, atau aktivitas serangga. Dokumentasikan temuan untuk evaluasi 
                                    efektivitas pengendalian dan perencanaan tindakan selanjutnya.
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
                            Sanitasi rutin & kebersihan alat.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Monitoring harian untuk deteksi dini.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Pestisida organik & ramah lingkungan.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Sirkulasi udara baik & siram pagi hari.
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">Sumber Artikel</h3>
                    <ol class="list-decimal list-inside space-y-2 text-slate-700 text-sm">
                        <li>
                            University of California IPM — "Strawberry Pest Management Guidelines".
                        </li>
                        <li>
                            Oregon State University Extension — "Common Strawberry Diseases & Pests".
                        </li>
                        <li>
                            FAO Plant Protection — "Integrated Pest Management for Berry Crops".
                        </li>
                    </ol>
                    <p class="text-xs text-slate-500 mt-3">
                        Panduan disarikan dari praktik pengendalian hama terpadu dan referensi universitas pertanian terkemuka.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                    <img src="{{ asset('images/pengendalian-hama.webp') }}"
                         alt="Pengendalian Hama"
                         class="w-full h-64 object-cover"
                         onerror="this.onerror=null; this.src='{{ asset('images/strawberry-farm.webp') }}';">
                </div>
            </aside>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6 md:p-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Hama & Penyakit Umum</p>
                <h2 class="text-2xl font-bold text-slate-900">Jenis-Jenis Serangan yang Sering Terjadi</h2>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Identifikasi dan penanganan berbagai jenis hama dan penyakit yang umum menyerang tanaman strawberry.
                </p>
            </div>
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                Fokus: identifikasi & penanganan tepat
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Hama Serangga</h3>
                <ul class="text-sm text-slate-700 space-y-2">
                    <li><strong>Kutu daun:</strong> Semprot dengan air sabun atau neem oil.</li>
                    <li><strong>Thrips:</strong> Gunakan perangkap kuning dan insektisida nabati.</li>
                    <li><strong>Tungau:</strong> Tingkatkan kelembapan dan semprot dengan air.</li>
                    <li><strong>Kumbang:</strong> Kumpulkan manual dan gunakan perangkap feromon.</li>
                </ul>
            </div>
            <div class="rounded-2xl border border-pink-100 bg-pink-50 p-5">
                <h3 class="text-lg font-semibold text-pink-900 mb-2">Penyakit Jamur</h3>
                <ul class="text-sm text-pink-900/80 space-y-2">
                    <li><strong>Busuk buah:</strong> Buang buah busuk, jaga kelembapan rendah.</li>
                    <li><strong>Bercak daun:</strong> Semprot fungisida organik, perbaiki sirkulasi udara.</li>
                    <li><strong>Jamur tepung:</strong> Semprot dengan baking soda atau sulfur.</li>
                    <li><strong>Busuk akar:</strong> Perbaiki drainase, hindari overwatering.</li>
                </ul>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-rose-50 p-5">
                <h3 class="text-lg font-semibold text-rose-900 mb-2">Penyakit Virus & Bakteri</h3>
                <ul class="text-sm text-rose-900/80 space-y-2">
                    <li><strong>Virus mosaik:</strong> Cabut tanaman terinfeksi, kontrol vektor.</li>
                    <li><strong>Layu bakteri:</strong> Rotasi bedengan, gunakan benih sehat.</li>
                    <li><strong>Bercak bakteri:</strong> Semprot tembaga, hindari penyiraman overhead.</li>
                    <li><strong>Nematoda:</strong> Rotasi tanaman, gunakan varietas tahan.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

