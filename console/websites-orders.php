<?php

require __DIR__ . './../vendor/autoload.php';



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://tresor-rare.com/index.php?route=papi/bi_api");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['site_id' => 1]));
$header = ["Accept: application/json", "test" => 'yes'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close($ch);

var_dump($server_output);
