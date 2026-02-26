<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =======================
// AUTH (LOGIN & REGISTER)
// =======================
$routes->get('/', 'Konser::index');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginProcess');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerProcess');

$routes->get('/logout', 'Auth::logout');


// =======================
// USER / CUSTOMER
// =======================

// daftar & detail konser
$routes->get('/konser', 'Konser::index');
$routes->get('/konser/(:num)', 'Konser::detail/$1');

// pemesanan tiket
$routes->get('/pesan/(:num)', 'Pemesanan::form/$1');
$routes->post('/pesan/submit', 'Pemesanan::submit');
$routes->get('/pesanan-saya', 'Pemesanan::riwayat');


// =======================
// PAYMENT (SIMULASI)
// =======================

// halaman pembayaran
$routes->get('/pemesanan/payment/(:num)', 'Pemesanan::payment/$1');

// proses bayar → ubah status jadi PAID
$routes->post('/pemesanan/process/(:num)', 'Pemesanan::process/$1');

// halaman tiket (belum tentu bisa download)
$routes->get('/pemesanan/tiket/(:num)', 'Pemesanan::tiket/$1');

// cetak tiket PDF (HANYA JIKA APPROVED)
$routes->get('/pemesanan/cetak/(:num)', 'Pemesanan::cetak/$1');


// =======================
// ADMIN
// =======================

$routes->get('/admin', 'Admin::index');

// CRUD konser
$routes->get('/admin/create', 'Admin::create');
$routes->post('/admin/store', 'Admin::store');
$routes->get('/admin/edit/(:num)', 'Admin::edit/$1');
$routes->post('/admin/update/(:num)', 'Admin::update/$1');
$routes->get('/admin/delete/(:num)', 'Admin::delete/$1');

// riwayat & approval
$routes->get('/admin/riwayat', 'Admin::riwayat');
$routes->get('/admin/approve/(:num)', 'Admin::approve/$1');
$routes->get('/admin/reject/(:num)', 'Admin::reject/$1');


// =======================
// API (OPSIONAL)
// =======================
$routes->group('api', function ($routes) {
    $routes->resource('konser', ['controller' => 'Api\KonserApi']);
});