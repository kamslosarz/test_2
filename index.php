<?php

include 'vendor/autoload.php';

ini_set('display_errors', '1');

error_reporting(E_ALL);

define('ENV', 'PROD');

/** @var \app\Response\Response $response */
$response = (new \app\Application())();
$response->send();
