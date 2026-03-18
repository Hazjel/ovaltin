<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Ringkas Administrasi Ovaltin</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 0;
            padding: 32px 36px;
            background-color: #ffffff;
        }
        h1, h2, h3 {
            color: #b91c1c;
            margin-bottom: 6px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 4px;
        }
        h2 {
            font-size: 16px;
            margin-top: 24px;
        }
        h3 {
            font-size: 14px;
            margin-top: 18px;
        }
        .meta {
            font-size: 11px;
            color: #4b5563;
            margin-bottom: 16px;
        }
        .grid {
            display: flex;
            gap: 16px;
        }
        .grid > div {
            flex: 1;
            border: 1px solid #f3f4f6;
            border-radius: 8px;
            padding: 12px 14px;
            background-color: #fff7ed;
        }
        .metric-title {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
        }
        .metric-value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 4px;
            color: #111827;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #fef2f2;
            color: #b91c1c;
            font-weight: bold;
        }
        .note {
            font-size: 10px;
            color: #6b7280;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    @php
        $sectionNumber = 1;
        $showSummaryCards = $sectionVisibility['users'] || $sectionVisibility['products'] || $sectionVisibility['testimonials'];
    @endphp
    <h1>Laporan Ringkas Administrasi</h1>
    <div class="meta">
        Dibuat pada: {{ $generatedAt->timezone(config('app.timezone'))->format('d/m/Y H:i') }} WIB<br>
        Periode Data: {{ $reportStart->copy()->timezone(config('app.timezone'))->format('d/m/Y') }} - {{ $reportEnd->copy()->timezone(config('app.timezone'))->format('d/m/Y') }}<br>
        Jenis Laporan: {{ $reportTypeLabel }} | Fokus Tren: Tahun {{ $reportYear }}
    </div>
    @if ($showSummaryCards)
        <div class="grid">
            @if ($sectionVisibility['users'])
                <div>
                    <span class="metric-title">Total Pengguna</span>
                    <div class="metric-value">{{ number_format($userStats['total']) }}</div>
                </div>
            @endif
            @if ($sectionVisibility['products'])
                <div>
                    <span class="metric-title">Total Produk</span>
                    <div class="metric-value">{{ number_format($productStats['total']) }}</div>
                </div>
                <div>
                    <span class="metric-title">Total Stok</span>
                    <div class="metric-value">{{ number_format($productStats['total_stock']) }}</div>
                </div>
            @endif
            @if ($sectionVisibility['testimonials'])
                <div>
                    <span class="metric-title">Testimoni Aktif</span>
                    <div class="metric-value">{{ number_format($testimonialsStats['approved']) }}</div>
                </div>
            @endif
        </div>
    @endif

    @if ($sectionVisibility['users'])
        <h2>{{ $sectionNumber++ }}. Statistik Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Admin</td>
                    <td>{{ number_format($userStats['admins']) }}</td>
                </tr>
                <tr>
                    <td>Pengguna Reguler</td>
                    <td>{{ number_format($userStats['members']) }}</td>
                </tr>
                <tr>
                    <td>Pendaftar Baru (periode dipilih)</td>
                    <td>{{ number_format($userStats['new_this_month']) }}</td>
                </tr>
            </tbody>
        </table>

        <h3>Pengguna Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->timezone(config('app.timezone'))->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h2>{{ $sectionNumber++ }}. Statistik Pengguna Tahunan ({{ $reportYear }})</h2>
        @if ($userTrendChart)
            <div style="text-align:center; margin-bottom: 16px;">
                <img src="{{ $userTrendChart }}" alt="Diagram Pertumbuhan User" style="max-width: 100%; height: auto;">
            </div>
        @endif
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Registrasi User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userTrend as $row)
                    <tr>
                        <td>{{ $row['label'] }}</td>
                        <td>{{ number_format($row['count']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($sectionVisibility['products'])
        <h2>{{ $sectionNumber++ }}. Distribusi Status Produk</h2>
        @if ($productStatusChart)
            <div style="text-align:center; margin-bottom: 16px;">
                <img src="{{ $productStatusChart }}" alt="Diagram Status Produk" style="max-width: 80%; height: auto;">
            </div>
        @endif
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Produk Tersedia</td>
                    <td>{{ number_format($productStats['active']) }}</td>
                </tr>
                <tr>
                    <td>Produk Tidak Tersedia</td>
                    <td>{{ number_format($productStats['inactive'] + $productStats['out_of_stock']) }}</td>
                </tr>
            </tbody>
        </table>

        <h3>Cuplikan Produk (15 entri terbaru)</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Asal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productSnapshot as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ?? '-' }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ number_format($product->stock_quantity) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $product->status ?? 'tidak diketahui')) }}</td>
                        <td>{{ $product->origin ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada data produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if ($sectionVisibility['testimonials'])
        <h2>{{ $sectionNumber++ }}. Testimoni per Rating</h2>
        @if ($ratingChart)
            <div style="text-align:center; margin-bottom: 16px;">
                <img src="{{ $ratingChart }}" alt="Diagram Testimoni per Rating" style="max-width: 100%; height: auto;">
            </div>
        @endif
        <table>
            <thead>
                <tr>
                    <th>Rating</th>
                    <th>Jumlah Testimoni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ratingLabels as $index => $label)
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ number_format($ratingData[$index]) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <ul class="metric-list">
            <li>Total Testimoni: {{ number_format($testimonialsStats['total']) }}</li>
            <li>Disetujui: {{ number_format($testimonialsStats['approved']) }}</li>
            <li>Menunggu Persetujuan: {{ number_format($testimonialsStats['pending']) }}</li>
        </ul>

        <h2>{{ $sectionNumber++ }}. Pertumbuhan Testimoni Tahunan ({{ $reportYear }})</h2>
        @if ($testimonialTrendChart)
            <div style="text-align:center; margin-bottom: 16px;">
                <img src="{{ $testimonialTrendChart }}" alt="Diagram Pertumbuhan Testimoni" style="max-width: 100%; height: auto;">
            </div>
        @endif
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Testimoni Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testimonialTrend as $row)
                    <tr>
                        <td>{{ $row['label'] }}</td>
                        <td>{{ number_format($row['count']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($sectionVisibility['contact'])
        <h2>{{ $sectionNumber++ }}. Informasi Kontak Utama</h2>
        @if ($activeContact)
            <table>
                <tbody>
                    <tr>
                        <th>Nama Perusahaan</th>
                        <td>{{ $activeContact->company_name ?? 'Ovaltin' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $activeContact->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $activeContact->phone_primary ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $activeContact->email_primary ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>WhatsApp</th>
                        <td>{{ $activeContact->whatsapp ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="note">Belum ada data kontak aktif yang tersimpan.</p>
        @endif
    @endif

    <p class="note">
        Dokumen ini digenerate otomatis oleh sistem Ovaltin. Silakan hubungi tim teknis bila Anda membutuhkan format laporan tambahan.
    </p>
</body>
</html>

