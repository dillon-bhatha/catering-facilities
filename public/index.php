<?php

require_once '../vendor/autoload.php';

$di = require __DIR__ . '/../config/services.php';

$router = $di->get('router');

// Haal de modellen uit de DI-container (voor de database)
$facilityModel = $di->get('facilityModel');
$locationModel = $di->get('locationModel');
$tagModel = $di->get('tagModel');

$pdo = $di->get('db');

// Maak de controller aan met de modellen als dependencies en de PDO verbinding
$facilityController = new \App\Controllers\FacilityController(
    $facilityModel,
    $locationModel,
    $tagModel,
    $pdo
);

// Routes
$router->get('/', function() use ($facilityController) {
    $facilityController->index();
});

$router->get('/facilities', function() use ($facilityController) {
    $facilityController->index();
});

$router->get('/facilities/(\d+)', function($id) use ($facilityController) {
    $facilityController->show($id);
});

$router->get('/facilities/(\d+)/edit', function($id) use ($facilityController) {
    $facilityController->edit($id);
});

$router->post('/facilities/(\d+)/edit', function($id) use ($facilityController) {
    $facilityController->update($id);
});

$router->post('/facilities/create', function() use ($facilityController) {
    $facilityController->store();
});

$router->get('/facilities/create', function() use ($facilityController) {
    $facilityController->create();
});

$router->post('/facilities/(\d+)/delete', function($id) use ($facilityController) {
    $facilityController->destroy($id);
});

$router->get('/facilities/search', function() use ($facilityController) {
    $facilityController->search();
});

$router->run();