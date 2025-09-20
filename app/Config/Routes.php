<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function($routes) {
    $routes->group('user', function($routes) {
        $routes->get('create', 'UserController::create');
        $routes->post('login', 'UserController::login');
        $routes->get('profile', 'UserController::profile', ['filter' => 'auth']);
    });
});