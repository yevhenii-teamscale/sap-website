<?php


use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/sap-orders', function (Request $request, Response $response, $args) {

    $sap_model = new \Model\SapOrders($this->db, $this->queries);
    $result = $sap_model->getDataFromSap(1);

    $sap_model->insertDataToSap($result);
});

$app->get('/sap-orders-all', function (Request $request, Response $response, $args) {

    $sap_model = new \Model\SapOrders($this->db, $this->queries);
    $result = $sap_model->getSapOrders();

    var_dump($result);
});

