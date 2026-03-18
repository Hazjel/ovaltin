@extends('layouts.app')

@section('title', 'Teknik Panen dan Penyimpanan Strawberry')

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
                    Teknik Panen dan Penyimpanan Strawberry
                </h1>
                <p class="text-slate-700 leading-relaxed max-w-2xl">
                    Pelajari waktu panen yang tepat dan teknik penyimpanan yang benar untuk menjaga kualitas, 
                    kesegaran, dan rasa strawberry tetap optimal hingga sampai ke konsumen.
                </p>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Waktu panen tepat
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-semibold border border-pink-100">
                        Teknik panen
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                        Penyimpanan optimal
                    </span>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rounded-3xl bg-pink-200/40 blur-3xl"></div>
                <img src="{{ asset('images/Strawberry Yield Harvest and Storage.jpg') }}"
                     alt="Panen Strawberry"
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
                            <p class="text-slate-600 text-sm mt-1">Tiga prinsip utama untuk panen dan penyimpanan yang optimal.</p>
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-pink-50 text-pink-700 text-sm font-semibold border border-pink-100">
                            Mode praktis: 3 prinsip utama
                        </div>
                    </div>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-pink-800 mb-2">Waktu Panen</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Panen saat strawberry mencapai 75-80% kematangan (merah). Waktu terbaik adalah pagi hari setelah embun mengering.
                            </p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-pink-50 to-white border border-pink-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-pink-800 mb-2">Teknik Panen</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Gunakan gunting tajam dan bersih. Potong tangkai buah dengan menyisakan sedikit tangkai untuk mencegah memar.
                            </p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 p-4 shadow-sm">
                            <h3 class="text-sm font-semibold text-emerald-800 mb-2">Penyimpanan</h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Simpan di suhu 0-5°C dengan kelembapan 90-95%. Jangan cuci sebelum disimpan dan hindari penumpukan berlebihan.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 md:p-8 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-pink-100 text-pink-700 font-bold">1</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Waktu Panen yang Tepat</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Panen strawberry saat buah mencapai 75-80% kematangan, ditandai dengan warna merah merata di seluruh permukaan. 
                                    Waktu terbaik adalah pagi hari setelah embun mengering (sekitar pukul 7-9 pagi) untuk menghindari buah basah. 
                                    Hindari panen saat hujan atau cuaca sangat panas. Panen yang tepat waktu menentukan kualitas rasa dan daya simpan.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-pink-100 text-pink-700 font-bold">2</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Teknik Panen yang Benar</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Gunakan gunting tajam dan bersih yang telah didesinfeksi. Potong tangkai buah sekitar 1 cm di atas buah, 
                                    jangan tarik langsung karena dapat merusak tanaman dan buah. Tangani buah dengan hati-hati, pegang bagian 
                                    tangkai bukan buahnya. Letakkan langsung ke wadah yang bersih dan jangan menumpuk terlalu banyak.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-700 font-bold">3</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Penyimpanan Optimal</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Simpan strawberry di suhu 0-5°C dengan kelembapan 90-95%. Jangan cuci buah sebelum disimpan karena akan 
                                    mempercepat pembusukan. Gunakan wadah berventilasi atau bungkus dengan kertas untuk sirkulasi udara. 
                                    Jangan menumpuk terlalu banyak, maksimal 2-3 lapis. Strawberry dapat bertahan 5-7 hari dalam kondisi optimal.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="h-10 w-10 flex items-center justify-center rounded-full bg-rose-100 text-rose-700 font-bold">4</span>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-1">Penanganan Pasca Panen</h3>
                                <p class="text-slate-700 leading-relaxed text-sm">
                                    Setelah panen, segera sortir buah untuk memisahkan yang rusak atau busuk. Dinginkan secepat mungkin untuk 
                                    memperlambat proses pematangan. Jika akan dikonsumsi langsung, cuci dengan air mengalir sebelum dimakan. 
                                    Untuk distribusi, gunakan kemasan yang melindungi buah dari tekanan dan getaran selama transportasi.
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
                            Panen di waktu tepat (75-80% matang).
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Gunakan alat bersih & teknik yang benar.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Penyimpanan suhu dingin (0-5°C).
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-white/80"></span>
                            Penanganan hati-hati & sortasi berkualitas.
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">Sumber Artikel</h3>
                    <ol class="list-decimal list-inside space-y-2 text-slate-700 text-sm">
                        <li>
                            University of California Postharvest — "Strawberry Harvest & Storage Guidelines".
                        </li>
                        <li>
                            Oregon State University Extension — "Harvesting and Storing Strawberries".
                        </li>
                        <li>
                            FAO Postharvest Management — "Best Practices for Berry Storage".
                        </li>
                    </ol>
                    <p class="text-xs text-slate-500 mt-3">
                        Panduan disarikan dari praktik pasca panen dan referensi universitas pertanian terkemuka.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                    <img src="{{ asset('images/Strawberry Yield Harvest and Storage.jpg') }}"
                         alt="Panen Strawberry"
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
                <h2 class="text-2xl font-bold text-slate-900">Faktor-Faktor yang Mempengaruhi Kualitas</h2>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Hal-hal penting yang perlu diperhatikan untuk menjaga kualitas strawberry dari panen hingga konsumsi.
                </p>
            </div>
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100">
                Fokus: kualitas & daya simpan
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Faktor Kualitas</h3>
                <ul class="text-sm text-slate-700 space-y-2">
                    <li><strong>Ukuran:</strong> Pilih buah seragam untuk presentasi baik.</li>
                    <li><strong>Warna:</strong> Merah merata tanpa bercak hijau atau putih.</li>
                    <li><strong>Tekstur:</strong> Padat, tidak lembek atau berair.</li>
                    <li><strong>Aroma:</strong> Harum khas strawberry yang segar.</li>
                </ul>
            </div>
            <div class="rounded-2xl border border-pink-100 bg-pink-50 p-5">
                <h3 class="text-lg font-semibold text-pink-900 mb-2">Kondisi Penyimpanan</h3>
                <ul class="text-sm text-pink-900/80 space-y-2">
                    <li><strong>Suhu:</strong> 0-5°C untuk memperlambat pembusukan.</li>
                    <li><strong>Kelembapan:</strong> 90-95% untuk mencegah layu.</li>
                    <li><strong>Ventilasi:</strong> Sirkulasi udara untuk mencegah jamur.</li>
                    <li><strong>Kemasan:</strong> Wadah berventilasi atau kertas.</li>
                </ul>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-rose-50 p-5">
                <h3 class="text-lg font-semibold text-rose-900 mb-2">Hindari Kesalahan</h3>
                <ul class="text-sm text-rose-900/80 space-y-2">
                    <li><strong>Jangan:</strong> Cuci sebelum disimpan.</li>
                    <li><strong>Jangan:</strong> Menumpuk terlalu banyak.</li>
                    <li><strong>Jangan:</strong> Simpan dengan buah lain yang cepat matang.</li>
                    <li><strong>Jangan:</strong> Biarkan terkena sinar matahari langsung.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

