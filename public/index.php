<?php

require __DIR__ . '/../vendor/autoload.php';

use PostgreSQL\Connection;

use Slim\Factory\AppFactory;
use DI\Container;

try {
    Connection::get()->connect();
    echo 'A connection to the PostgreSQL database sever has been established successfully.';
} catch (\PDOException $e) {
    echo $e->getMessage();
}

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    $params = [];
    return $this->get('renderer')->render($response, 'index.html', $params);
});


$app->run();
