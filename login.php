<?php
include 'load.php';

// Check if the request method is OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Set the appropriate CORS headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Authorization, Content-Type"); // Cache preflight request for 1 day
    exit; // Stop script execution
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set the appropriate CORS headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    // Get the JSON data from the request body
    $json_data = file_get_contents('php://input');

    // Decode the JSON data
    $decoded_data = json_decode($json_data, true);

    // Check if JSON data decoding was successful
    if ($decoded_data !== null) {
        // Store the decoded data in variables
        $regid = $decoded_data['regid'];
        $password = $decoded_data['password'];
        $result = user::login($regid, $password);

        // Prepare the response
        $response = array(
            'access_token' => $result,
        );
    } else {
        // Return an error response if JSON decoding failed
        $response = array('error' => 'Failed to decode JSON data');
    }

    // Encode the response data as JSON and output it
    echo json_encode($response);
}
?>
