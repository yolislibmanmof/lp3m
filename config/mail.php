<?php

/**
 * ══════════════════════════════════════════════════════════════
 *  KONFIGURASI PENGIRIMAN EMAIL — LP3M UNIMOF
 * ══════════════════════════════════════════════════════════════
 *
 *  driver 'mail' : mail() PHP native.
 *                  ⚠️ Hanya andal di server produksi (cPanel/VPS dengan MTA).
 *                  Di localhost (Laragon/XAMPP) email TIDAK akan sampai
 *                  meskipun log mencatat "sent".
 *
 *  driver 'smtp' : SMTP client murni PHP (tanpa library eksternal).
 *                  ✅ WAJIB untuk testing di localhost, dan paling andal
 *                  bahkan di produksi.
 *
 *  ── CONTOH KONFIGURASI ────────────────────────────────────────
 *  Gmail     : host=smtp.gmail.com     port=465 enc=ssl  (APP PASSWORD)
 *              alternatif              port=587 enc=tls
 *  cPanel    : host=mail.domain.com    port=465 enc=ssl  (password email)
 *  Office365 : host=smtp.office365.com port=587 enc=tls
 *  Brevo     : host=smtp-relay.brevo.com port=587 enc=tls (SMTP KEY)
 *
 *  🔑 Gmail App Password:
 *     Aktifkan 2FA → https://myaccount.google.com/apppasswords
 *     → buat app password 16 karakter → tempel di 'password'.
 *
 *  🔑 Brevo SMTP Key:
 *     Dashboard → SMTP & API → Generate SMTP Key → salin key
 *     WAJIB: Authorize IP publik + Verify sender email di dashboard
 *
 *  🧪 Setelah mengisi kredensial, verifikasi lewat tombol
 *     "🔌 Test Koneksi SMTP" di halaman Newsletter & Broadcast.
 * ══════════════════════════════════════════════════════════════
 */
return [
    'driver'       => 'smtp',
    'host'         => 'smtp-relay.brevo.com',
    'port'         => 587,
    'encryption'   => 'tls',
    'username'     => 'b88439001@smtp-brevo.com',
    'password'     => 'xsmtpsib-6a0e5fe252ee2f911d823970c33ea00d12c96bc26e8e99439fd4e13faf088826-babwfVMJ3Oxt0lPy',
    'from_email'   => 'libmanozhez57@gmail.com',  // ← WAJIB: sender yang sudah diverifikasi di Brevo
    'from_name'    => 'LP3M Web',                   // ← WAJIB: nama pengirim yang tampil di inbox
    'timeout'      => 15,
];