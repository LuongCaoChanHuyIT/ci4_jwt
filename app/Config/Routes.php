<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', ['filter' => 'cors'], function (RouteCollection $routes) {
    // Xử lý preflight request (OPTIONS)
    $routes->options('(:any)', function () {
        return service('response')->setStatusCode(204);
    });

    // Nhóm user (public)
    $routes->group('user', function (RouteCollection $routes) {
        $routes->post('login', 'UserController::login'); // không cần token
    });

    // Nhóm các route cần token
    $routes->group('user', ['filter' => 'auth'], function (RouteCollection $routes) {
        $routes->get('profile', 'UserController::profile');
        $routes->post('update', 'UserController::update');
    });
});
