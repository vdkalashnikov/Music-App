<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// app/Config/Routes.php
$routes->get('/', 'Home::index');
$routes->get('lagu/(:num)/(:num)', 'Home::lagu/$1/$2');
$routes->get('/api/songs', 'Home::getSongs');
$routes->get('/artis/(:num)', 'Home::artis/$1');

