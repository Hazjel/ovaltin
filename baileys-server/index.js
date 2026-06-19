const { default: makeWASocket, useMultiFileAuthState, DisconnectReason, fetchLatestBaileysVersion } = require('@whiskeysockets/baileys');
const pino = require('pino');
const qrcode = require('qrcode-terminal');
const QRCodePNG = require('qrcode');
const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
app.use(express.json());

const PORT = 3000;
let sock = null;
let qrCodeText = null;
let connectionStatus = 'disconnected';

const ARTIFACTS_DIR = 'C:\\Users\\Lenovo\\.gemini\\antigravity\\brain\\81367dbc-facd-4290-b24a-56cc9a8b904e';

async function connectToWhatsApp() {
    console.log('Inisialisasi koneksi ke WhatsApp...');
    connectionStatus = 'connecting';
    
    try {
        const { version, isLatest } = await fetchLatestBaileysVersion();
        console.log(`Menggunakan versi WhatsApp Web: ${version.join('.')}, isLatest: ${isLatest}`);

        const { state, saveCreds } = await useMultiFileAuthState(path.join(__dirname, 'auth_info_baileys'));
        
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
                    else {
                        console.log(`QR Code disimpan di server: ${qrServerPath}`);
                        
                        if (fs.existsSync(ARTIFACTS_DIR)) {
                            const qrArtifactPath = path.join(ARTIFACTS_DIR, 'qr.png');
                            try {
                                fs.copyFileSync(qrServerPath, qrArtifactPath);
                                console.log(`QR Code disalin ke folder Chat: ${qrArtifactPath}`);
                            } catch (copyErr) {
                                console.error('Gagal menyalin file QR ke artifacts:', copyErr);
                            }
                        }
                    }
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
                
                const qrArtifactPath = path.join(ARTIFACTS_DIR, 'qr.png');
                if (fs.existsSync(qrArtifactPath)) {
                    try { fs.unlinkSync(qrArtifactPath); } catch(e) {}
                }
                
                if (shouldReconnect) {
                    setTimeout(connectToWhatsApp, 5000);
                } else {
                    console.log('Perangkat di-logout. Silakan jalankan ulang server untuk scan QR code baru.');
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
                
                const qrArtifactPath = path.join(ARTIFACTS_DIR, 'qr.png');
                if (fs.existsSync(qrArtifactPath)) {
                    try { fs.unlinkSync(qrArtifactPath); } catch(e) {}
                }
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

app.post('/send-message', async (req, res) => {
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
