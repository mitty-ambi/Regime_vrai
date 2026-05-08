<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/livres','LivreController::index');
$routes->get('/livres/filtre','LivreController::filtre');

// Routes d'authentification
$routes->get('/auth/inscription', 'Auth::inscription');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/register', 'Auth::register');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->get('/auth/logout', 'Auth::logout');

// Routes dashboard
$routes->get('/dashboard', 'Dashboard::index');