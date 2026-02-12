<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =======================
// AUTH (LOGIN & REGISTER)
// =======================
$routes->get('/', 'Konser::index');

$routes->get('/login', 'Auth::login');                 // halaman login
$routes->post('/login', 'Auth::loginProcess');         // proses login
$routes->get('/register', 'Auth::register');           // halaman register
$routes->post('/register', 'Auth::registerProcess');   // proses register
$routes->get('/logout', 'Auth::logout');               // logout user


// =======================
// USER / CUSTOMER
// =======================

// daftar konser
$routes->get('/konser', 'Konser::index');              
$routes->get('/konser/(:num)', 'Konser::detail/$1');   // detail konser

// pemesanan tiket
$routes->get('/pesan/(:num)', 'Pemesanan::form/$1');   // form pesan tiket
$routes->post('/pesan/submit', 'Pemesanan::submit');  // submit pesanan
$routes->get('/pesanan-saya', 'Pemesanan::riwayat');  // riwayat pesanan user

// ===== PAYMENT SIMULASI =====
$routes->get('/pemesanan/payment/(:num)', 'Pemesanan::payment/$1');   // halaman payment
$routes->get('/pemesanan/process/(:num)', 'Pemesanan::process/$1');   // proses bayar (ubah status)
$routes->get('/pemesanan/tiket/(:num)', 'Pemesanan::tiket/$1');       // download tiket PDF
$routes->post('/pemesanan/process/(:num)', 'Pemesanan::process/$1');


// =======================
// ADMIN
// =======================
$routes->get('/admin', 'Admin::index');                // dashboard admin
$routes->get('/admin/create', 'Admin::create');        // form tambah konser
$routes->post('/admin/store', 'Admin::store');         // simpan konser
$routes->get('/admin/edit/(:num)', 'Admin::edit/$1');  // edit konser
$routes->post('/admin/update/(:num)', 'Admin::update/$1'); // update konser
$routes->get('/admin/delete/(:num)', 'Admin::delete/$1'); // hapus konser
$routes->get('/admin/riwayat', 'Admin::riwayat');      // riwayat penjualan
