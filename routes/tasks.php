<?php


use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/update-all', function (Request $request, Response $response, $args) {

    echo 'start updating' . PHP_EOL;
    echo 'updating sap orders' . PHP_EOL;

    exec('php index.php sap-orders');

    echo 'updating web orders' . PHP_EOL;

    exec('php index.php web');

    echo 'done';
});

