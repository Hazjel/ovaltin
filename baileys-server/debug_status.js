const { default: makeWASocket, useMultiFileAuthState, fetchLatestBaileysVersion } = require('@whiskeysockets/baileys');
const pino = require('pino');
const path = require('path');

const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

async function trackMessageStatus() {
    console.log('Menghubungkan ke WhatsApp...');
    const { version } = await fetchLatestBaileysVersion();
    const { state } = await useMultiFileAuthState(path.join(__dirname, 'auth_info_baileys'));
    
    const sock = makeWASocket({
        version,
        auth: state,
        logger: pino({ level: 'silent' })
    });

    sock.ev.on('messages.update', (updates) => {
        console.log('\n--- UPDATE PESAN DITERIMA ---');
        for (const update of updates) {
            console.log(JSON.stringify(update, null, 2));
        }
        console.log('-----------------------------\n');
    });

    sock.ev.on('connection.update', async (update) => {
        const { connection } = update;
        
        if (connection === 'open') {
            console.log('Koneksi TERBUKA. Menunggu 10 detik agar stabil...');
            await delay(10000);
            
            const targetPhone = '6289652179403';
            const jid = `${targetPhone}@s.whatsapp.net`;
            
            try {
                console.log(`Mengirim pesan ke ${targetPhone}...`);
                const response = await sock.sendMessage(jid, { text: 'Test pelacakan status pesan' });
                console.log('Respons awal kirim:', JSON.stringify(response.key, null, 2));
                
                console.log('Menunggu 20 detik untuk melihat perubahan status pesan...');
                await delay(20000);
                
                console.log('Selesai melacak status!');
                process.exit(0);
            } catch (err) {
                console.error('Error saat kirim:', err);
                process.exit(1);
            }
        }
    });
}

trackMessageStatus();
