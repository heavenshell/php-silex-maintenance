<?php
require_once 'silex.phar';
require_once dirname(__DIR__) . '/src/MaintenanceExtension.php';

$app = new Silex\Application();
$app->register(new \MaintenanceExtension(), array(
    'maintenance.path' => __DIR__ . '/sample',
    'maintenance.file' => __DIR__ . '/maintenance.twig',
));

$app->get('/', function () use ($app) {
    return '/';
});

if (getenv('SILEX_TEST')) {
    return $app;
}
$app->run();
