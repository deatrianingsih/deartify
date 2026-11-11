<?php

/*
 * Area pengiriman & ongkir.
 * Ubah angka 'fee' atau nama kota di sini, tidak perlu ubah kode lain.
 */
return [
    // Nama kota toko (tampil di keterangan "Dalam Kota")
    'city' => 'Kota Anda',

    'areas' => [
        'local' => [
            'label' => 'Dalam Kota',
            'icon' => 'bi-geo-alt',
            'fee' => 0,
            'note' => 'Gratis ongkir. Bisa bayar COD atau QR.',
            'cod' => true,
        ],
        'outside' => [
            'label' => 'Luar Kota',
            'icon' => 'bi-truck',
            'fee' => 15000,
            'note' => 'Dikirim lewat kurir. Wajib bayar QR (COD tidak tersedia).',
            'cod' => false,
        ],
    ],
];
