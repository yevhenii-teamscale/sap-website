<?php
// DIC configuration

$container = $app->getContainer();

//  SQL queries for sap-inventory
$container['queries'] = function ($c) {
    return $c->get('settings')['queries'];
};

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// db connection 1 - connection to SAP_INTEGRATION_DB - reconnector to other DBs
$container['db'] = function ($c) {
    $db_settings = $c->get('settings')['db'];
    $pdo = new PDO( $db_settings['pdo_string']. $db_settings['dbname'],$db_settings['user'], $db_settings['pass']);
    $pdo->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// db connection 1 - DB of US
$container['db_api_1'] = function ($c) {
    $db_settings = $c->get('settings')['db_api'];
    $pdo = new PDO($db_settings['pdo_string'] . $db_settings['dbname_site1'],$db_settings['user'], $db_settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// db connection 2 - DB of UK
$container['db_api_2'] = function ($c) {
    $db_settings = $c->get('settings')['db_api'];
    $pdo = new PDO ($db_settings['pdo_string'] . $db_settings['dbname_site2'], $db_settings['user'], $db_settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// db connection 3 - DB of EU
$container['db_api_3'] = function ($c) {
    $db_settings = $c->get('settings')['db_api'];
    $pdo = new PDO ($db_settings['pdo_string'] . $db_settings['dbname_site3'], $db_settings['user'], $db_settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// monolog
 $container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//Models
/*$container[model\Products::class] = function($c){
    return new \model\Products($c);
}; */
