<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$wa = app(\App\Services\WhatsAppService::class);
$phone = '6289652179403';
echo "Mengirim test WA via local Baileys ke {$phone}...\n";
$status = $wa->sendTest($phone);

if ($status) {
    echo "BERHASIL! Pesan terkirim.\n";
} else {
    echo "GAGAL! Silakan periksa log server Baileys atau Laravel log.\n";
}
