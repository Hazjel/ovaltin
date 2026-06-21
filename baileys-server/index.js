const { default: makeWASocket, useMultiFileAuthState, DisconnectReason, fetchLatestBaileysVersion } = require('@whiskeysockets/baileys');
const pino = require('pino');
const qrcode = require('qrcode-terminal');
const QRCodePNG = require('qrcode');
const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
app.use(express.json());
app.use((req, res, next) => {
    res.set('Cache-Control', 'no-store, no-cache, must-revalidate, proxy-revalidate');
    next();
});

const PORT = process.env.PORT || 3000;
const AUTH_DIR = path.join(__dirname, 'auth_info_baileys');
let sock = null;
let qrCodeText = null;
let connectionStatus = 'disconnected';

async function connectToWhatsApp() {
    console.log('Inisialisasi koneksi ke WhatsApp...');
    connectionStatus = 'connecting';
    
    try {
        const { version, isLatest } = await fetchLatestBaileysVersion();
        console.log(`Menggunakan versi WhatsApp Web: ${version.join('.')}, isLatest: ${isLatest}`);

        const { state, saveCreds } = await useMultiFileAuthState(AUTH_DIR);
        
        sock = makeWASocket({
            version,
            auth: state,
            printQRInTerminal: false,
            logger: pino({ level: 'info' }) // Gunakan level 'info' agar terlihat logs pengiriman & koneksi
        });

        sock.ev.on('connection.update', async (update) => {
            const { connection, lastDisconnect, qr } = update;
            
            if (qr) {
                qrCodeText = qr;
                console.clear();
                console.log('\n==================================================');
                console.log('  PINDAI QR CODE INI DENGAN WHATSAPP DI HP ANDA   ');
                console.log('==================================================\n');
                qrcode.generate(qr, { small: true });
                console.log('\nPetunjuk:');
                console.log('1. Buka WhatsApp di HP Anda.');
                console.log('2. Buka Menu / Setelan -> Perangkat Tertaut (Linked Devices).');
                console.log('3. Pilih Tautkan Perangkat dan arahkan kamera ke QR Code di atas.\n');

                const qrServerPath = path.join(__dirname, 'qr.png');
                QRCodePNG.toFile(qrServerPath, qr, {
                    color: {
                        dark: '#000000',
                        light: '#ffffff'
                    },
                    width: 300
                }, (err) => {
                    if (err) console.error('Gagal membuat file PNG QR Code di server:', err);
                    else console.log(`QR Code disimpan di server: ${qrServerPath}`);
                });
            }

            if (connection === 'close') {
                const statusCode = lastDisconnect?.error?.output?.statusCode;
                const shouldReconnect = statusCode !== DisconnectReason.loggedOut;
                
                console.log(`Koneksi terputus. Status: ${statusCode}. Mencoba menghubungkan kembali: ${shouldReconnect}`);
                connectionStatus = 'disconnected';
                qrCodeText = null;
                
                const qrServerPath = path.join(__dirname, 'qr.png');
                if (fs.existsSync(qrServerPath)) fs.unlinkSync(qrServerPath);

                if (shouldReconnect) {
                    setTimeout(connectToWhatsApp, 5000);
                } else {
                    console.log('Perangkat di-logout. Menghapus sesi lama dan membuat QR code baru...');
                    fs.rmSync(AUTH_DIR, { recursive: true, force: true });
                    setTimeout(connectToWhatsApp, 2000);
                }
            } else if (connection === 'open') {
                console.clear();
                console.log('\n==================================================');
                console.log('  WHATSAPP SERVER BERHASIL TERHUBUNG! 🎉         ');
                console.log('==================================================');
                console.log(`Server siap menerima request di http://localhost:${PORT}\n`);
                connectionStatus = 'connected';
                qrCodeText = null;
                
                const qrServerPath = path.join(__dirname, 'qr.png');
                if (fs.existsSync(qrServerPath)) fs.unlinkSync(qrServerPath);
            }
        });

        sock.ev.on('creds.update', saveCreds);

    } catch (err) {
        console.error('Error saat inisialisasi Baileys:', err);
        console.log('Mencoba lagi dalam 5 detik...');
        setTimeout(connectToWhatsApp, 5000);
    }
}

connectToWhatsApp();

app.get('/status', (req, res) => {
    res.json({
        status: connectionStatus,
        hasQr: !!qrCodeText
    });
});

function checkQrToken(req, res) {
    const secret = process.env.QR_SECRET;
    if (secret && req.query.token !== secret) {
        res.status(403).send('Akses ditolak.');
        return false;
    }
    return true;
}

app.get('/qr', (req, res) => {
    if (!checkQrToken(req, res)) return;

    const qrServerPath = path.join(__dirname, 'qr.png');
    if (!fs.existsSync(qrServerPath)) {
        return res.status(404).send('QR code tidak tersedia. Server mungkin sudah terhubung atau belum siap.');
    }
    res.sendFile(qrServerPath);
});

app.get('/qr-page', (req, res) => {
    if (!checkQrToken(req, res)) return;

    const token = req.query.token || '';
    res.send(`<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Scan QR WhatsApp - Dapur Ovaltin</title>
<style>
    * { box-sizing: border-box; }
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        text-align: center;
        background: #f8fafc;
        padding: 48px 16px;
        margin: 0;
        color: #0f172a;
    }
    .card {
        max-width: 360px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 32px 24px;
    }
    h1 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 4px;
    }
    .subtitle {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0 0 20px;
    }
    .badge {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 999px;
        margin-bottom: 20px;
    }
    .badge.connecting { background: #fef3c7; color: #92400e; }
    .badge.connected { background: #dcfce7; color: #166534; }
    .badge.disconnected { background: #fee2e2; color: #991b1b; }
    #qrBox {
        width: 240px;
        height: 240px;
        margin: 0 auto;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    img { width: 100%; height: 100%; border-radius: 8px; }
    #empty { color: #64748b; font-size: 0.8rem; padding: 0 16px; }
</style>
</head>
<body>
    <div class="card">
        <h1>Hubungkan WhatsApp</h1>
        <p class="subtitle">Dapur Ovaltin — Gateway Notifikasi</p>
        <span id="statusBadge" class="badge connecting">Memuat status...</span>
        <div id="qrBox">
            <img id="qrImg" src="" alt="QR Code" style="display:none;">
            <p id="empty">Menunggu QR code...</p>
        </div>
    </div>
    <script>
        const token = ${JSON.stringify(token)};
        const badge = document.getElementById('statusBadge');
        const img = document.getElementById('qrImg');
        const empty = document.getElementById('empty');

        function setBadge(text, cls) {
            badge.textContent = text;
            badge.className = 'badge ' + cls;
        }

        async function refresh() {
            try {
                const res = await fetch('/status?t=' + Date.now());
                const data = await res.json();

                if (data.status === 'connected') {
                    setBadge('Terhubung', 'connected');
                    img.style.display = 'none';
                    empty.textContent = 'WhatsApp sudah terhubung.';
                    empty.style.display = 'block';
                    return;
                }

                setBadge(data.status === 'connecting' ? 'Menyambungkan' : 'Terputus', data.status === 'connecting' ? 'connecting' : 'disconnected');

                if (data.hasQr) {
                    img.src = '/qr?token=' + encodeURIComponent(token) + '&t=' + Date.now();
                    img.style.display = 'inline-block';
                    empty.style.display = 'none';
                } else {
                    img.style.display = 'none';
                    empty.textContent = 'Menunggu QR code...';
                    empty.style.display = 'block';
                }
            } catch (e) {
                setBadge('Gagal memuat', 'disconnected');
            }
        }
        refresh();
        setInterval(refresh, 3000);
    </script>
</body>
</html>`);
});

app.post('/send-message', async (req, res) => {
    const apiKey = process.env.API_KEY;
    if (apiKey && req.headers['x-api-key'] !== apiKey) {
        return res.status(403).json({ error: 'Akses ditolak.' });
    }

    const { phone, message } = req.body;

    if (!phone || !message) {
        return res.status(400).json({ error: 'Nomor telepon dan pesan wajib diisi!' });
    }

    if (connectionStatus !== 'connected') {
        return res.status(503).json({ error: 'Server WhatsApp belum terhubung/belum di-scan!' });
    }

    try {
        let cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }
        
        const jid = `${cleanPhone}@s.whatsapp.net`;
        
        console.log(`Mengirim pesan ke: ${cleanPhone}...`);
        
        const response = await sock.sendMessage(jid, { text: message });

        res.json({ success: true, message: 'Pesan berhasil dikirim', data: response });
    } catch (error) {
        console.error('Gagal mengirim pesan:', error);
        res.status(500).json({ error: 'Gagal mengirim pesan', details: error.message });
    }
});

app.listen(PORT, '0.0.0.0', () => {
    console.log(`Express server berjalan di port ${PORT}`);
});
