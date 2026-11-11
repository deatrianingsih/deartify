<?php

return [
    /*
     * Metode pembayaran non-COD (pakai QR + unggah bukti).
     * Gambar QR disimpan di public/images/qris.jpg
     * Kalau file gambarnya tidak ada, metode ini otomatis "Belum tersedia".
     */
    'wallets' => [
        'qris' => [
            'label' => 'QR DANA',            // ganti jadi 'QRIS' kalau QR kamu memang QRIS (bisa discan semua aplikasi)
            'icon' => 'bi-qr-code-scan',
            'image' => 'images/qris.jpg',
            'number' => '',                   // nomor DANA (opsional, tampil di bawah QR)
            'name' => '',                     // atas nama (opsional)
        ],
        'gopay' => [
            'label' => 'GoPay',
            'icon' => 'bi-wallet2',
            'image' => 'images/gopay.jpg',    // taruh gambar QR GoPay di public/images/gopay.jpg
            'number' => '081574793771',       // nomor GoPay
            'name' => '',                     // atas nama (opsional)
        ],
        'ovo' => [
            'label' => 'OVO',
            'icon' => 'bi-wallet',
            'image' => 'images/ovo.jpg',      // taruh gambar QR OVO di public/images/ovo.jpg
            'number' => '081574793771',       // nomor OVO
            'name' => '',                     // atas nama (opsional)
        ],
    ],

    // Catatan yang tampil ke customer (kosongkan kalau tidak perlu)
    'note' => 'Scan QR, bayar sesuai total pesanan, lalu unggah bukti pembayaran.',
];
