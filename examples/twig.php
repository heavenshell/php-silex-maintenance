<?php
require_once 'silex.phar';
require_once dirname(__DIR__) . '/src/MaintenanceExtension.php';

$app = new Silex\Application();
$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path'       => __DIR__ . '/views',
    'twig.class_path' => getenv('TWIG_PATH')
));
$app->register(new \MaintenanceExtension(), array(
    'maintenance.lock' => __DIR__ . '/maintenance',
    'maintenance.file' => 'maintenance.twig',
));


$app->get('/', function () use ($app) {
    return '/';
});

if (getenv('SILEX_TEST')) {
    return $app;
}
$app->run();
