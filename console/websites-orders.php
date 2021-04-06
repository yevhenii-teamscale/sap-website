<?php

require __DIR__ . './../vendor/autoload.php';

$website = new \Model\WebsiteOrders($container['db'], $container['settings']['queries']);

echo 'Clear website_orders table' . PHP_EOL;
$website->truncateTable();

$websitesList = $website->websites;
if (isset($argv[2])){
    $websitesList = $website->getWebsite($argv[2]);

    if (empty($websitesList)){
        die('Nothing found');
    }
}

$countAllRows = 0;
foreach ($websitesList as $site) {
    echo 'Getting data from ' . $site['name'] . PHP_EOL;

    $data = $website->getDataFromWebsite($site['url']);

    $count = count($data);
    $countAllRows += $count;

    echo 'Inserting data to DB. Rows: ' . $count . PHP_EOL;

    if($data != null){
        $website->insertDataToWebsiteOrdersTable($data);
    }
}

echo 'Inserted: ' . $countAllRows . PHP_EOL;
