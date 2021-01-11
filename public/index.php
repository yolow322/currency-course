<?php

require_once '../vendor/autoload.php';

use App\Core\Application;
use App\Http\Controller\CurrencyController;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$envConfig = [
    'db' => [
        'dsn' => $_ENV['DSN'],
        'user' => $_ENV['USER'],
        'password' => $_ENV['PASSWORD'],
    ]
];

$application = new Application($envConfig);

$application->router->get('/home', 'home');

$application->router->get('/home', [
    CurrencyController::class,
    'getCharCodeAndNames'
]);

$application->router->get('/home/create-currency-chart', [
    CurrencyController::class,
    'createChart'
]);

$application->router->get('/home/show-currencies', [
    CurrencyController::class,
    'getListOfCurrencies'
]);

$application->router->post('/home/refresh-database', [
    CurrencyController::class,
    'insertNewCurrencies'
]);

$application->run();

