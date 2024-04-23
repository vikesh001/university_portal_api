<?
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
?>