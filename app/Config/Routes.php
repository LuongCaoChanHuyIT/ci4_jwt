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

    // Group user
    $routes->group('user', function (RouteCollection $routes) {
        $routes->post('login', 'UserController::login');
    });
});
