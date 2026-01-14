<?php

/**
 * Property Module Routes
 *
 * Defines all routes for the Property module, including
 * admin CRUD operations and public frontend routes.
 */

namespace App\Modules\Property\Config;

use Config\Services;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Frontend Routes
 * --------------------------------------------------------------------
 */
$routes->group('properties', ['namespace' => 'App\Modules\Property\Controllers\Frontend'], function ($routes) {
    $routes->get('/', 'PropertyController::index');
    $routes->get('(:segment)', 'PropertyController::show/$1');
});

/*
 * --------------------------------------------------------------------
 * Admin Routes (protected by auth filter)
 * --------------------------------------------------------------------
 */
$routes->group('admin/properties', ['namespace' => 'App\Modules\Property\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PropertyController::index');
    $routes->get('create', 'PropertyController::create');
    $routes->post('/', 'PropertyController::store');
    $routes->get('(:num)', 'PropertyController::show/$1');
    $routes->get('(:num)/edit', 'PropertyController::edit/$1');
    $routes->put('(:num)', 'PropertyController::update/$1');
    $routes->post('(:num)', 'PropertyController::update/$1'); // Fallback for forms without PUT support
    $routes->delete('(:num)', 'PropertyController::delete/$1');
    $routes->post('(:num)/delete', 'PropertyController::delete/$1'); // Fallback for forms without DELETE support
});
