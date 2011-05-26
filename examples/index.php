<?php
require_once 'silex.phar';
require_once dirname(__DIR__) . '/src/MaintenanceExtension.php';

$app = new Silex\Application();
$app->register(new \MaintenanceExtension(), array(
    'maintenance.lock' => __DIR__ . '/maintenance',
    'maintenance.file' => __DIR__ . '/maintenance.html',
));

$app->get('/', function () use ($app) {
    return '/';
});

$app->post('/', function () use ($app) {
    return '/';
});

$app->put('/', function () use ($app) {
    return '/';
});

$app->delete('/', function () use ($app) {
    return '/';
});

if (getenv('SILEX_TEST')) {
    return $app;
}
$app->run();
