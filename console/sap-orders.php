<?php

require __DIR__ . './../vendor/autoload.php';



$sap_model = new \Model\SapOrders($container['db'], $container['settings']['queries']);
$result = $sap_model->getDataFromSap(1);

$sap_model->insertDataToSap($result);
