<?php


use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/website-orders', function (Request $request, Response $response, $args) {

    $sap_model = new \Model\WebsiteOrders($this->db, $this->queries);
    $result = $sap_model->getWebsiteOrders();

    var_dump($result);
});

