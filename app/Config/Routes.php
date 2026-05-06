<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/livres','LivreController::index');
$routes->get('/livres/filtre','LivreController::filtre');