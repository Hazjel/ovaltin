<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Notifikasi pengingat data penjualan — berjalan setiap menit
// Command akan mengecek sendiri apakah hari & jam sudah tepat (Selasa/Jumat, 10:00 & 20:00)
Schedule::command('notify:sales-reminder')->everyMinute();
