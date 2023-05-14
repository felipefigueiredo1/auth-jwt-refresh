<?php

use Dotenv\Dotenv;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With");
header('Content-type: application/json');
error_reporting(0);
ini_set('display_errors', '0');

$dotenv = Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();
