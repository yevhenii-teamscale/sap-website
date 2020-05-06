<?php

require __DIR__ . './../vendor/autoload.php';


$sap_model = new \Model\SapOrders($container['db'], $container['settings']['queries']);

echo 'Clear the table' . PHP_EOL;
$sap_model->truncateTable();

$countAllRows = 0;
foreach ($sap_model->saps as $sap) {
    echo 'Getting data from ' . $sap['sap_name'] . '. Site ID: ' . $sap['site_id'] . PHP_EOL;

    $data = $sap_model->getDataFromSap($sap['sap_url'], $sap['site_id']);

    $count = count($data);
    $countAllRows += $count;

    echo 'Inserting data to DB. Rows: ' . $count . PHP_EOL;

    $sap_model->insertDataToSapOrdersTable($data);
}

echo 'Inserted: ' . $countAllRows . PHP_EOL;


