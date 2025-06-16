<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/api/mahasiswa', 'Mahasiswa::index');
$routes->get('/api/dosen', 'Dosen::index');
$routes->get('/api/prodi', 'Prodi::index');
$routes->get('/api/matkul', 'Matkul::index');
$routes->get('/api/admin', 'Admin::index');
$routes->get('/api/penilaian', 'Penilaian::index');


$routes->post('/api/mahasiswa/create', 'Mahasiswa::create');
$routes->post('/api/prodi/create', 'Prodi::create');
$routes->post('/api/matkul/create', 'Matkul::create');
$routes->post('/api/dosen/create', 'Dosen::create');
$routes->post('/api/penilaian/create', 'Penilaian::create');


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


