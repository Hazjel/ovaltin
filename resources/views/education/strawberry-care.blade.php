@extends('layouts.app')

@section('title', 'Perawatan & Pemupukan Strawberry')

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
                    Perawatan & Pemupukan Strawberry
                </h1>
                <p class="text-slate-700 leading-relaxed max-w-2xl">
                    Langkah terstruktur untuk menjaga kelembapan, nutrisi, dan kesehatan tanaman berry Anda,
                    sehingga buah tetap besar, manis, dan sehat sepanjang musim.
                </p>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Irigasi terukur
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Pupuk seimbang
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                        pH ideal 5.5–6.5
                    </span>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rounded-3xl bg-pink-200/40 blur-3xl"></div>
                <img src="https://images.unsplash.com/photo-1464454709131-ffd692591ee5?w=1200&h=800&fit=crop"
                     alt="Perawatan Strawberry"
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
                            <p class="text-slate-600 text-sm mt-1">Tiga fokus utama untuk menjaga tanaman tetap sehat.</p>
                        </div>
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-pink-50 text-pink-700 text-sm font-semibold border border-pink-100">
                        Mode praktis: 3 poin inti
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                        <h3 class="text-sm font-semibold text-pink-800 mb-2">Irigasi</h3>
                        <p class="text-slate-700 text-sm leading-relaxed">
                            Siram ringan 2–3x/minggu, hindari genangan, gunakan mulsa supaya lembap stabil.
                        </p>
                    </div>
                    <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                        <h3 class="text-sm font-semibold text-pink-800 mb-2">Nutrisi</h3>
                        <p class="text-slate-700 text-sm leading-relaxed">
                            Pupuk organik matang + NPK seimbang (15-15-15) dosis rendah setiap 3–4 minggu.
                        </p>
                    </div>
                    <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 p-4 shadow-sm">
                        <h3 class="text-sm font-semibold text-emerald-800 mb-2">pH & Media</h3>
                        <p class="text-slate-700 text-sm leading-relaxed">
                            Jaga pH 5.5–6.5, tambah dolomit bila asam, pastikan drainase baik dan bersih.
                        </p>
                    </div>
                </div>
                </section>

                <section class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-pink-100 text-pink-700 font-bold">1</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Irigasi</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Siraman dangkal tapi rutin, fokus menjaga lembap tanpa genang. Mulsa organik
                                    membantu kestabilan suhu dan mengurangi gulma.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-pink-100 text-pink-700 font-bold">2</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Pemupukan</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Pupuk dasar organik 2–3 minggu sebelum tanam. Setelah tanam, beri NPK seimbang
                                    dosis rendah per 3–4 minggu, tambah kalsium/boron sesuai kebutuhan buah.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-700 font-bold">3</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">pH & Media</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    pH ideal 5.5–6.5. Jika asam, koreksi dengan dolomit. Pastikan drainase baik,
                                    karena akar strawberry sensitif pada genangan berkepanjangan.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-rose-100 text-rose-700 font-bold">4</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Higiene & Hama</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Buang daun/buah busuk, gunakan insektisida nabati (neem), dan jaga kebersihan
                                    bedengan untuk menekan jamur serta serangga.
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
                            Drainase baik + mulsa.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Irigasi terukur, hindari overwatering.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Pupuk seimbang & organik matang.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Monitoring pH & kebersihan bedengan.
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">Sumber Artikel</h3>
                    <ol class="list-decimal list-inside space-y-2 text-slate-700 text-sm">
                        <li>
                            Oregon State University Extension — “Growing Strawberries in Your Home Garden”.
                        </li>
                        <li>
                            University of California ANR — “Strawberry Irrigation & Fertility Guidelines”.
                        </li>
                        <li>
                            FAO Horticulture Notes — “Soil pH Management for Berry Crops”.
                        </li>
                    </ol>
                    <p class="text-xs text-slate-500 mt-3">
                        Ringkasan disarikan dari referensi hortikultura universitas dan praktik lapangan berry.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1464454709131-ffd692591ee5?w=900&h=700&fit=crop"
                         alt="Perawatan Strawberry"
                         class="w-full h-64 object-cover">
                </div>
            </aside>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6 md:p-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Perlindungan Tambahan</p>
                <h2 class="text-2xl font-bold text-slate-900">Pengendalian Hama & Penyakit</h2>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Langkah preventif untuk menjaga bedengan tetap bersih, menekan serangan serangga, dan mencegah jamur.
                </p>
            </div>
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                Fokus: higienitas & monitoring rutin
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Sanitasi Kebun</h3>
                <ul class="text-sm text-slate-700 space-y-2">
                    <li>Buang daun/buah busuk setiap hari untuk menekan spora jamur.</li>
                    <li>Gunakan mulsa bersih, ganti bila kotor/berjamur.</li>
                    <li>Pastikan alat panen bersih sebelum dipakai.</li>
                </ul>
            </div>
            <div class="rounded-2xl border border-pink-100 bg-pink-50 p-5">
                <h3 class="text-lg font-semibold text-pink-900 mb-2">Pengendalian Serangga</h3>
                <ul class="text-sm text-pink-900/80 space-y-2">
                    <li>Aplikasikan insektisida nabati (neem) ringan tiap 7–10 hari.</li>
                    <li>Pasang perangkap kuning untuk kutu daun & thrips.</li>
                    <li>Periksa bagian bawah daun setiap minggu.</li>
                </ul>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-rose-50 p-5">
                <h3 class="text-lg font-semibold text-rose-900 mb-2">Antijamur & Virus</h3>
                <ul class="text-sm text-rose-900/80 space-y-2">
                    <li>Jaga sirkulasi udara; hindari tanaman terlalu rapat.</li>
                    <li>Siraman pagi hari agar daun cepat kering.</li>
                    <li>Rotasi bedengan jika ada gejala virus/layu berat.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
