<?php

require __DIR__ . './../vendor/autoload.php';

$website = new \Model\WebsiteOrders($container['db'], $container['settings']['queries']);

echo 'Clear website_orders table' . PHP_EOL;
$website->truncateTable();

$countAllRows = 0;
foreach ($website->websites as $site) {
    echo 'Getting data from ' . $site['name'] . PHP_EOL;

    $data = $website->getDataFromSap($site['url']);

    $count = count($data);
    $countAllRows += $count;

    echo 'Inserting data to DB. Rows: ' . $count . PHP_EOL;

    $website->insertDataToWebsiteOrdersTable($data);
}

echo 'Inserted: ' . $countAllRows . PHP_EOL;
