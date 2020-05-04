<?php

require __DIR__ . './../vendor/autoload.php';



$sap_model = new \Model\SapOrders($container['db'], $container['settings']['queries']);

echo 'getting data from SAP' . PHP_EOL;

$result = $sap_model->getDataFromSap(1);

echo 'inserting data to DB' . PHP_EOL;

$sap_model->insertDataToSap($result);

echo 'finished' . PHP_EOL;
