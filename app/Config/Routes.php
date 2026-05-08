<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'RegimeController::go_to_regime');

$routes->get('/Regime/go_to_regime', 'RegimeController::go_to_regime');

$routes->post('/Regime/insert', 'RegimeController::insert');