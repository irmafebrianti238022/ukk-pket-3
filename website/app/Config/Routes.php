<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');
$routes->post('/auth/proses_login', 'Auth::proses_login');
$routes->get('/logout', 'Auth::logout');

$routes->get('/login-siswa', 'Auth::login_siswa');
$routes->post('/auth/proses_login_siswa', 'Auth::proses_login_siswa');

// Proteksi halaman admin dengan filter 'auth'
$routes->group('admin', ['filter' => ['auth', 'roleAdmin']], function($routes) {
$routes->get('dashboard', 'Admin::index');
$routes->get('tanggapan/(:num)', 'Admin::tanggapan/$1');
$routes->post('simpan_tanggapan', 'Admin::simpan_tanggapan');
$routes->get('hapus/(:num)', 'Admin::hapus/$1');

$routes->get('kategori', 'Kategori::index');
$routes->post('kategori/simpan', 'Kategori::simpan');
$routes->post('kategori/ubah/(:num)', 'Kategori::ubah/$1');
$routes->get('kategori/hapus/(:num)', 'Kategori::hapus/$1');

$routes->get('siswa', 'SiswaAdmin::index');
$routes->post('siswa/simpan', 'SiswaAdmin::simpan');
$routes->post('siswa/ubah/(:segment)', 'SiswaAdmin::ubah/$1');
$routes->get('siswa/hapus/(:segment)', 'SiswaAdmin::hapus/$1');
});

// halaman siswa
$routes->group('siswa', ['filter' => ['auth', 'roleSiswa']], function($routes) {
$routes->get('dashboard', 'Siswa::index');
$routes->get('tambah_aspirasi', 'Siswa::tambah'); 
$routes->post('simpan', 'Siswa::simpan');
$routes->post('ubah_aspirasi/(:num)', 'Siswa::ubah_aspirasi/$1');
$routes->get('hapus_aspirasi/(:num)', 'Siswa::hapus_aspirasi/$1');
});