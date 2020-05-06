<?php

require __DIR__ . './../vendor/autoload.php';



$sap_model = new \Model\SapOrders($container['db'], $container['settings']['queries']);


echo 'Clear the table' . PHP_EOL;
$sap_model->truncateTable();

echo 'Getting data from SAP Israel' . PHP_EOL;
$result = $sap_model->getDataFromSap($sap_model->sap_israel, 1);

$count = count($result);
echo 'Inserting data to DB. Items: ' . $count . PHP_EOL;
$sap_model->insertDataToSap($result);

echo 'Getting data from SAP USA site Id 1' . PHP_EOL;
$result = $sap_model->getDataFromSap($sap_model->sap_usa, 1);

$count = count($result);
echo 'Inserting data to DB. Items: ' . $count . PHP_EOL;
$sap_model->insertDataToSap($result);

echo 'Getting data from SAP USA site Id 3' . PHP_EOL;
$result = $sap_model->getDataFromSap($sap_model->sap_usa, 3);

$count = count($result);
echo 'Inserting data to DB. Items: ' . $count . PHP_EOL;
$sap_model->insertDataToSap($result);
