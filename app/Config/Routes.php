<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::inscription');

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

// Régime - CRUD complet
$routes->get('/Regime/go_to_regime', 'RegimeController::go_to_regime');
$routes->post('/Regime/insert', 'RegimeController::insert');
$routes->get('/Regime/update/(:num)', 'RegimeController::update/$1');
$routes->post('/Regime/edit/(:num)', 'RegimeController::edit/$1');
$routes->get('/Regime/supprimer/(:num)', 'RegimeController::supprimer/$1');
// Regime - suggestion de regime
$routes->get('/Regime/suggest',function () {
    return view('regime/SuggestRegime');
});

// Activites - CRUD complet
$routes->get('/Activites/add', 'ActiviteController::go_to_activite');
$routes->post('/Activites/insert', 'ActiviteController::insert');
$routes->get('/Activites/update/(:num)', 'ActiviteController::update/$1');
$routes->post('/Activites/edit/(:num)', 'ActiviteController::edit/$1');
$routes->get('/Activites/supprimer/(:num)', 'ActiviteController::supprimer/$1');

// Codes - CRUD complet + Validation
$routes->get('/codes/liste', 'CodeController::listeCodes');
$routes->get('/codes/ajouter', 'CodeController::ajouterCode');
$routes->post('/codes/inserer', 'CodeController::insererCode');
$routes->get('/codes/modifier/(:num)', 'CodeController::modifierCode/$1');
$routes->post('/codes/update/(:num)', 'CodeController::updateCode/$1');
$routes->get('/codes/supprimer/(:num)', 'CodeController::supprimerCode/$1');

// Codes - Front office (Porte monnaie)
$routes->get('/codes/ajouter-credit', 'CodeController::ajouterCredit');
$routes->post('/codes/valider', 'CodeController::validerCode');