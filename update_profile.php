<?php
include 'load.php';

// Check if the request method is OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Set the appropriate CORS headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
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
            print("jwt key is invalid");
        }else{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the JSON data from the request body
            $json_data = file_get_contents('php://input');
        
            // Decode the JSON data
            $data = json_decode($json_data, true);
        
        // Check if JSON data decoding was successful
        if ($data !== null) {
        $address = $data['address'];
        $phone = $data['phone'];
        $blood_group = $data['blood_group'];
        $department = $data['department'];
        $cgpa = $data['cgpa'];
        $dob = $data['dob'];
        $data=new data();
        $result=$data->update_profile($regid, $address, $phone, $blood_group, $department, $cgpa, $dob);
        echo json_encode($result);
        }
        
    
    }}}else {
    // Key does not exist, handle the situation accordingly
    $authorization = null; // or any default value you want
    echo "Authorization header is not set.";
}


}
?>