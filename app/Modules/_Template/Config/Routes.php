<?php

/**
 * _Template Module Routes
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. 'templates' -> '{modulename}' (kucuk harf, cogul)
 * 2. 'App\Modules\_Template' -> 'App\Modules\{ModuleName}'
 * 3. 'TemplateController' -> '{ModuleName}Controller'
 */

namespace App\Modules\_Template\Config;

use Config\Services;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Frontend Routes
 * --------------------------------------------------------------------
 */
$routes->group('templates', ['namespace' => 'App\Modules\_Template\Controllers\Frontend'], function ($routes) {
    $routes->get('/', 'TemplateController::index');
    $routes->get('(:segment)', 'TemplateController::show/$1');
});

/*
 * --------------------------------------------------------------------
 * Admin Routes (protected by auth filter)
 * --------------------------------------------------------------------
 */
$routes->group('admin/templates', ['namespace' => 'App\Modules\_Template\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'TemplateController::index');
    $routes->get('create', 'TemplateController::create');
    $routes->post('/', 'TemplateController::store');
    $routes->get('(:num)', 'TemplateController::show/$1');
    $routes->get('(:num)/edit', 'TemplateController::edit/$1');
    $routes->put('(:num)', 'TemplateController::update/$1');
    $routes->post('(:num)', 'TemplateController::update/$1');
    $routes->delete('(:num)', 'TemplateController::delete/$1');
    $routes->post('(:num)/delete', 'TemplateController::delete/$1');
});
