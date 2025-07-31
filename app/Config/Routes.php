<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', static function ($routes) {
    // 🚨 Najpierw trasy specyficzne (wagony)
    $routes->post('coasters/(:segment)/wagons', 'WagonController::create/$1');
    $routes->delete('coasters/(:segment)/wagons/(:segment)', 'WagonController::delete/$1/$2');

    // 🎯 Dopiero potem resource (bo łapie wildcardy)
    $routes->resource('coasters', [
        'controller' => 'CoasterController',
    ]);
});




