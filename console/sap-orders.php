<?php

require __DIR__ . './../vendor/autoload.php';



$sap_model = new \Model\SapOrders($container['db'], $container['settings']['queries']);

echo 'getting data from SAP Israel' . PHP_EOL;

$result = $sap_model->getDataFromSap($sap_model->sap_israel, 1);

$count = count($result);

echo 'inserting data to DB. Items: ' . $count . PHP_EOL;

$sap_model->insertDataToSap($result);

echo 'getting data from SAP USA site 1' . PHP_EOL;

$result = $sap_model->getDataFromSap($sap_model->sap_usa, 1);

$count = count($result);

echo 'inserting data to DB. Items: ' . $count . PHP_EOL;

$sap_model->insertDataToSap($result);

echo 'getting data from SAP USA site 3' . PHP_EOL;

$result = $sap_model->getDataFromSap($sap_model->sap_usa, 3);

$count = count($result);

echo 'inserting data to DB. Items: ' . $count . PHP_EOL;

$sap_model->insertDataToSap($result);

echo 'finished' . PHP_EOL;
