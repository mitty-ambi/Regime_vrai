<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::inscription');
$routes->get('/livres','LivreController::index');
$routes->get('/livres/filtre','LivreController::filtre');

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
$routes->post('/dashboard/updatePoids', 'Dashboard::updatePoids');
$routes->post('/dashboard/updatePhoto', 'Dashboard::updatePhoto');

// Routes objectifs
$routes->get('/objectif/choix', 'Objectif::choix');
$routes->post('/objectif/sauvegarder', 'Objectif::sauvegarder');
$routes->get('/objectif/suivi', 'Objectif::suivi');
