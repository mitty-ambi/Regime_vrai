<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Routes d'authentification
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/register', 'Auth::register');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->get('/auth/logout', 'Auth::logout');

// Routes informations santé
$routes->get('/sante/info', 'Sante::info');
$routes->post('/sante/save', 'Sante::save');

// Routes dashboard
$routes->get('/dashboard', 'Dashboard::index');
// Routes d'authentification
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/register', 'Auth::register');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->get('/auth/logout', 'Auth::logout');

// Routes informations santé
$routes->get('/sante/info', 'Sante::info');
$routes->post('/sante/save', 'Sante::save');

// Routes dashboard
$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/Regime/go_to_regime', 'RegimeController::go_to_regime');
$routes->post('/Regime/insert', 'RegimeController::insert');
