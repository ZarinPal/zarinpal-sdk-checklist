<?php

//require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

use ZarinPal\Sdk\ClientBuilder;
use ZarinPal\Sdk\ZarinPal;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;

//die(var_dump(get_declared_classes()));


$clientBuilder = new ClientBuilder();
$clientBuilder->addPlugin(new HeaderDefaultsPlugin([
    'Accept' => 'application/json',
]));

$sdk = new ZarinPal($clientBuilder);
$response = $sdk->todos()->all();