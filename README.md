# Ovaltin — Dapur Ovaltin

Web app untuk **Dapur Ovaltin**, usaha rumahan produk olahan stroberi di Desa Lebakmuncang, Kabupaten Bandung, Jawa Barat.

![Deployed](https://img.shields.io/badge/deployed-production-brightgreen)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Laravel](https://img.shields.io/badge/Laravel-12-red)

## Fitur

- Katalog produk (Agar, Dodol, Krupuk, Selai)
- Input & laporan data penjualan (manual + import Excel)
- Forecasting permintaan (regresi linear)
- Manajemen FAQ, testimoni, kontak
- Artikel edukasi budidaya stroberi
- Admin back-office dengan role management

## Tech Stack

- **Backend**: PHP 8.2 + Laravel 12
- **Frontend**: Blade + Tailwind CSS v4 + Alpine.js
- **Database**: MySQL
- **Hosting**: Domainesia (dapurovaltin.com)

## Setup Lokal

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
composer dev
```
