<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class Database
{
    public static $conn = null;
    public static function getConnection()
    {
        if (Database::$conn == null) {
            $servername = "mysql.selfmade.ninja";
            $user = "university";
            $pass = "password";
            $dbname = "university_clg";
        
            // Create connection
            $connection = new mysqli($servername, $user, $pass, $dbname);
            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error); //TODO: Replace this with exception handling
            } else {
              //s  printf("New connection establishing...");
                Database::$conn = $connection; //replacing null with actual connection
                return Database::$conn;
            }
        } else {
           // printf("Returning existing establishing...");
            return Database::$conn;
        }
    }
}

class user{
    private $conn;    // Database connection
    private $reg_id;  // User's reg_id
    private $id;        // User's ID 
    private $key = "vit";


    public static function login($regid, $password)
    {
        $key = "vit";
        $conn = Database::getConnection();
    
        try {
            $sql = "SELECT * FROM Credentials WHERE reg_id=?";
    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $regid);
    
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        $payload = ['reg_id' => $regid];
                        $jwt = JWT::encode($payload, $key, 'HS256');
                        return $jwt;
                        // Password matches, you can set session variables here
                        
                    }
                }
            }
    
            return false; // User does not exist or password is incorrect
        } catch (mysqli_sql_exception $e) {
            return $e; // Handle the error gracefully
        } finally {
            if ($stmt !== null) {
                $stmt->close();}
            $conn->close();
        }
    }

    public function verify($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
            $decoded_array = (array) $decoded;
            return($decoded_array['reg_id']);
            
        } catch (Exception $e) {
            return false; // Handle the error gracefully
        }
    }

}


?> 