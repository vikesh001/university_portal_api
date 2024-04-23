<?php
include 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include_once '/home/mrvikesh123/uni/include/user_class.php';
include_once '/home/mrvikesh123/uni/include/data_class.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

?>