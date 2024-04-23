<?php
include 'load.php';

// Check if the request method is OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Set the appropriate CORS headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Authorization, Content-Type");
    header("Access-Control-Max-Age: 86400"); // Cache preflight request for 1 day
    exit; // Stop script execution
}


if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    // Key exists, retrieve the value
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];

    if (strpos($authorization, 'Bearer') === 0) {
        $jwt = trim(substr($authorization, 7));
        $user = new user();
        $regid = $user->verify($jwt);
        
        if($regid==null){
            print("no");
        }else{
           print($regid); 
        }

        
    
    }}else {
    // Key does not exist, handle the situation accordingly
    $authorization = null; // or any default value you want
    echo "Authorization header is not set.";
}



?>