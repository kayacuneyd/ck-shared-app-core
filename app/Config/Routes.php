<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use Config\Services;

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 *
 * This file defines the routes for the application. It sets
 * defaults and maps URIs to controllers and methods.
 */

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('Frontend\\HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// You can enable Auto Routing (Improved) if you wish to avoid defining
// all routes by hand. The route definitions here make it explicit which
// routes are available.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Home page
$routes->get('/', 'Frontend\\HomeController::index');

// Authentication
$routes->get('login', 'Auth\\LoginController::index');
$routes->post('login', 'Auth\\LoginController::attempt');
$routes->get('logout', 'Auth\\LoginController::logout');

// Admin routes group with auth filter
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // When visiting /admin or /admin/dashboard, show the dashboard
    $routes->get('/', 'Admin\\DashboardController::index');
    $routes->get('dashboard', 'Admin\\DashboardController::index');
});

/*
 * --------------------------------------------------------------------
 * Module Routes
 * --------------------------------------------------------------------
 */

// Load Property Module routes
require_once APPPATH . 'Modules/Property/Config/Routes.php';
