<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('me', 'Me::index');

$routes->get('/', 'Home::index', ['filter' => 'auth']);

//Tampil
$routes->get('/api/mahasiswa', 'Mahasiswa::index');
$routes->get('/api/dosen', 'Dosen::index');
$routes->get('/api/prodi', 'Prodi::index');
$routes->get('/api/matkul', 'Matkul::index');
$routes->get('/api/admin', 'Admin::index');
$routes->get('/api/penilaian', 'Penilaian::index');

//penilaian
$routes->get('/api/penilaian/belum-diisi', 'Penilaian::penilaianBelumDiisi');
$routes->get('/api/penilaian/riwayat', 'Penilaian::riwayatPenilaian');


//Get BY ID-Show
$routes->get('/api/mahasiswa/(:num)', 'Mahasiswa::show/$1');
$routes->get('api/prodi/(:num)', 'Prodi::show/$1');
$routes->get('api/dosen/(:num)', 'Dosen::show/$1');
$routes->get('api/matkul/(:num)', 'Matkul::show/$1');
$routes->get('api/penilaian/(:num)', 'Penilaian::show/$1');
$routes->get('api/admin/(:num)', 'Admin::show/$1');

//Get All
$routes->get('api/prodi/getAll', 'Prodi::getAll');
$routes->get('api/matkul/getAll', 'Matkul::getAll');
$routes->get('api/dosen/getAll', 'Dosen::getAll');
$routes->get('api/penilaian/getAll', 'Matkul::getAll');
$routes->get('api/mahasiswa/getAll', 'Mahasiswa::getAll');
$routes->get('api/admin/getAll', 'Admin::getAll');


//MENAMBAH
$routes->post('/api/mahasiswa/create', 'Mahasiswa::create');
$routes->post('/api/prodi/create', 'Prodi::create');
$routes->post('/api/matkul/create', 'Matkul::create');
$routes->post('/api/dosen/create', 'Dosen::create');
$routes->post('/api/penilaian/create', 'Penilaian::create');
$routes->post('/api/admin/create', 'Admin::create');


$routes->post('register', 'Register::index');
$routes->post('login', 'Login::index');
$routes->get('login', 'Login::index');

$routes->put('/api/prodi/update/(:num)', 'Prodi::update/$1');
$routes->put('/api/mahasiswa/update/(:num)', 'Mahasiswa::update/$1');
$routes->put('/api/matkul/update/(:num)', 'Matkul::update/$1');
$routes->put('/api/dosen/update/(:num)', 'Dosen::update/$1');
$routes->put('/api/admin/update/(:num)', 'Admin::update/$1');
$routes->put('/api/penilaian/update/(:num)', 'Penilaian::update/$1');


$routes->delete('/api/prodi/delete/(:num)', 'Prodi::delete/$1');
$routes->delete('/api/mahasiswa/delete/(:num)', 'Mahasiswa::delete/$1');
$routes->delete('/api/matkul/delete/(:num)', 'Matkul::delete/$1');
$routes->delete('/api/dosen/delete/(:num)', 'Dosen::delete/$1');
$routes->delete('/api/penilaian/delete/(:num)', 'Penilaian::delete/$1');
$routes->delete('/api/admin/delete/(:num)', 'Admin::delete/$1');


