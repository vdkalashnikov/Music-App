<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('user', static function ($routes) {
    // Rute untuk pengguna yang sudah login (auth)
    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
        $routes->get('home', 'Home::index', ['as' => 'user.home']);
        $routes->get('logout', 'Home::logoutUserHandler', ['as' => 'user.logout']);
        $routes->get('laguById/(:any)', 'Home::laguById/$1', ['as' => 'user.lagu.track']);
        $routes->get('lagu/(:any)/(:any)', 'Lagu::lagu/$1/$2', ['as' => 'user.lagu']);
        $routes->get('lagu_album/(:any)/(:any)', 'Lagu::laguByAlbum/$1/$2', ['as' => 'user.lagu.album']);
        $routes->get('api/songs', 'Home::getSongs');
        $routes->get('artis/(:any)', 'Artis::index/$1', ['as' => 'user.artis']);
        $routes->get('album/(:any)', 'Album::index/$1', ['as' => 'user.album']);
        $routes->get('spotify/album/(:any)', 'Home::spotifyAlbum/$1', ['as' => 'user.spotifyAlbum']);
        $routes->get('spotify/track/(:any)', 'Home::spotifyTrack/$1', ['as' => 'user.spotifyTrack']);
        $routes->get('spotifyArtist/(:any)', 'Home::spotifyArtist/$1', ['as' => 'user.spotifyArtist']);
        $routes->get('spotify/playlist/(:any)', 'Home::spotifyPlaylist/$1', ['as' => 'user.spotifyPlaylist']);
        $routes->get('profile', 'Home::profile', ['as' => 'user.profile']);
        $routes->get('search', 'Home::search', ['as' => 'user.search']);
        $routes->post('spotify/search', 'Home::searchSpotify', ['as' => 'user.searchSpotify']);
        $routes->post('profile/update', 'Home::updateProfile', ['as' => 'user.profile.update']);
        $routes->post('update-profile-picture', 'Home::updateProfilePicture', ['as' => 'user.update.picture']);
        $routes->post('change-password', 'Home::changePassword', ['as' => 'user.change.password']);
    });

    // Rute untuk pengguna yang belum login (guest)
    $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {
        $routes->get('/', 'AuthController::loginUserForm', ['as' => 'user.login.form']);
        $routes->get('login', 'AuthController::loginUserForm', ['as' => 'user.login.form']);
        $routes->post('login', 'AuthController::loginUserHandler', ['as' => 'user.login.handler']);
        $routes->get('forgot-password', 'AuthController::forgotForm', ['as' => 'user.forgot.password']);
        $routes->post('forgot-password', 'AuthController::sendPasswordResetLink', ['as' => 'user.send_password_reset_link']);
        $routes->get('password/reset/(:any)', 'AuthController::resetPassword/$1', ['as' => 'user.reset-password']);
        $routes->post('reset-password-handler/(:any)', 'AuthController::resetPasswordHandler/$1', ['as' => 'reset-password-handler']);
    });

    // Rute untuk pendaftaran pengguna baru
    $routes->get('register', 'Register::registerForm', ['as' => 'user.register']);
    $routes->post('register', 'Register::saveForm', ['as' => 'user.save']);
});
