<?php
include 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Check if the Authorization header is set
if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    // Key exists, retrieve the value
    $authorization = $_SERVER['HTTP_AUTHORIZATION'];

    if (strpos($authorization, 'Bearer') === 0) {
        $jwt = trim(substr($authorization, 8));
        
        try {
            $decoded = JWT::decode($jwt, new Key("vit", 'HS256'));
            $decoded_array = (array) $decoded;

            echo $decoded;
            // Your code to handle the decoded JWT
            if ($decoded_array != null) {
                
            } else {
                echo "Invalid token.";
            }
        } catch (Exception $e) {
            // Handle JWT decoding errors
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
} else {
    // Key does not exist, handle the situation accordingly
    $authorization = null; // or any default value you want
    echo "Authorization header is not set.";
}
echo "The end";
?>
