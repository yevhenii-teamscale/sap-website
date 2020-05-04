<?php

//For cross-site requests
header("Access-Control-Allow-Origin: *");

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/vendor/autoload.php';

//echo  dirname(__FILE__);
//echo  json_encode($_SERVER['SERVER_NAME']);
//echo  json_encode($_SERVER);
//die;

// choose the proper settings file for US or ISR server
//ISR server: 192.115.202.221
if ($_SERVER['SERVER_NAME'] == "67.23.63.117") {

    $settings = require __DIR__ . '/src/settings_us.php';

} else {

    $settings = require __DIR__ . '/src/settings_isr.php';

}

//add queries
$queries = require __DIR__ . '/src/queries.php';
$settings['settings']['queries'] = $queries;


$app = new \Slim\App($settings);
$container = $app->getContainer();

// Set up dependencies
require __DIR__ . '/src/dependencies.php';

// Register middleware
require __DIR__ . '/src/middleware.php';

//Site Inventory API/Order Information
//model
require __DIR__ . '/model/sap-orders.php';

//router
require __DIR__ . '/routes/sap-orders.php';

// Run app
$app->run();
