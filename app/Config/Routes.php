<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('user', static function ($routes) {

    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
        $routes->get('home', 'Home::index', ['as' => 'user.home']);
        $routes->get('logout', 'Home::logoutUserHandler', ['as' => 'user.logout']);
        $routes->get('lagu/(:num)/(:num)', 'Home::lagu/$1/$2', ['as' => 'user.lagu']); // Added route
        $routes->get('api/songs', 'Home::getSongs');
        $routes->get('artis/(:num)', 'Home::artis/$1', ['as' => 'user.artis']);
    });

    $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {
        $routes->get('/', 'AuthController::loginUserForm', ['as' => 'user.login.form']);
        $routes->get('login', 'AuthController::loginUserForm', ['as' => 'user.login.form']);
        $routes->post('login', 'AuthController::loginUserHandler', ['as' => 'user.login.handler']);
    });
});
