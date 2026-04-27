<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('login/captcha', 'Auth::captcha');
$routes->get('logout', 'Auth::logout');

$routes->get('barang/(:num)', 'Assets::show/$1');
$routes->post('barang/(:num)/pinjam', 'Peminjaman::pinjam/$1');
$routes->post('barang/(:num)/kembalikan', 'Peminjaman::kembalikan/$1');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    $routes->get('barang', 'Assets::index');
    $routes->get('barang/create', 'Assets::create');
    $routes->post('barang/store', 'Assets::store');
    $routes->get('barang/(:num)/edit', 'Assets::edit/$1');
    $routes->post('barang/(:num)/update', 'Assets::update/$1');
    $routes->get('barang/(:num)/delete', 'Assets::delete/$1');

    $routes->get('users', 'Users::index');
    $routes->get('users/create', 'Users::create');
    $routes->post('users/store', 'Users::store');
    $routes->get('users/(:num)/edit', 'Users::edit/$1');
    $routes->post('users/(:num)/update', 'Users::update/$1');
    $routes->get('users/(:num)/delete', 'Users::delete/$1');

    $routes->get('history', 'Peminjaman::history');
});
