<?php


use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/update-all', function (Request $request, Response $response, $args) {

    exec('php index.php sap-orders');
    exec('php index.php web');

    echo 'done';
});

