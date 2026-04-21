<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/captcha', 'Auth::captcha');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/assets', 'Assets::index');
$routes->get('/assets/create', 'Assets::create');
$routes->post('/assets/store', 'Assets::store');
$routes->get('/assets/(:num)', 'Assets::show/$1');
