<?php


use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/sap-orders', function (Request $request,Response $response, $args) {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://10.0.0.5/site-api/sap-orders");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        http_build_query(['site_id' => '1']));

    // Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    var_dump($server_output);

    curl_close ($ch);

});

