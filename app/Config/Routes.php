<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. ROUTE AUTH (Login/Logout) - Tidak kena filter Auth
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

// 2. ROUTE UTAMA (Semua route di dalam sini DILINDUNGI login)
// Perhatikan: Kita pakai variabel '$r' di dalam group untuk menghindari error
$routes->group('', ['filter' => 'auth'], function($r) {
    
    // Dashboard Home
    $r->get('/', 'Home::index');
    
    // --- MODUL PASIEN ---
    $r->group('pasien', function($sub) {
        $sub->get('/', 'Pasien::index');        // Halaman View
        $sub->get('read', 'Pasien::read');      // JSON DataTables
        $sub->post('save', 'Pasien::save');     // Simpan (Baru/Edit)
        $sub->post('delete', 'Pasien::delete'); // Hapus
        $sub->get('import', 'Pasien::import');  // Import JSON Placeholder
        $sub->get('cetak/(:num)', 'Pasien::cetak/$1'); // Tambahkan ini

    });

    // --- MODUL PENDAFTARAN (Yang tadi 404) ---
    $r->group('pendaftaran', function($sub) {
        $sub->get('/', 'Pendaftaran::index');
        $sub->get('read', 'Pendaftaran::read');
        $sub->get('listPasien', 'Pendaftaran::listPasien'); // Dropdown Pasien
        $sub->post('save', 'Pendaftaran::save');
        $sub->post('delete', 'Pendaftaran::delete');
        $sub->get('cetak/(:num)', 'Pendaftaran::cetak/$1'); // Cetak Struk
    });

    // --- MODUL KUNJUNGAN ---
    $r->group('kunjungan', function($sub) {
        $sub->get('/', 'Kunjungan::index');
        $sub->get('read', 'Kunjungan::read');
        $sub->get('listPendaftaran', 'Kunjungan::listPendaftaran'); // Dropdown No Reg
        $sub->post('save', 'Kunjungan::save');
        $sub->post('delete', 'Kunjungan::delete');
        $sub->get('cetak/(:num)', 'Kunjungan::cetak/$1'); // Tambahkan ini
    });

    // --- MODUL ASESMEN ---
    $r->group('asesmen', function($sub) {
        $sub->get('/', 'Asesmen::index');
        $sub->get('read', 'Asesmen::read');
        $sub->get('listKunjungan', 'Asesmen::listKunjungan'); // Dropdown Kunjungan
        $sub->post('save', 'Asesmen::save');
        $sub->post('delete', 'Asesmen::delete');
        $sub->get('cetak/(:num)', 'Asesmen::cetak/$1');
    });

});