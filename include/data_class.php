<?php
class data{
    private $conn; // Declare $conn as a class property

    // Constructor to initialize the database connection
    function __construct() {
        $this->conn = $this->conn(); // Call conn() method to initialize $conn
    }

    // Function to establish database connection
    private function conn() {
        $host = "mysql.selfmade.ninja";
        $user = "university";
        $password = "password";
        $database = "university_clg";

        try {
            $connection = new mysqli($host, $user, $password, $database);
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            return $connection;
        } catch (Exception $e) {
            echo "Error connecting to MySQL: " . $e->getMessage();
            return null;
        }
    }

// Function to retrieve attendance information
function attendance($regid, $semid) {
    
    if ($this->conn === null) {
        echo "Database connection is not established.";
        return;
    }
    $query = "SELECT c.Course_id, c.Course, a.tot_classes AS `TOT NO CLASS`, a.tot_present AS `TOT PRESENT`
            FROM Attendance a
            INNER JOIN Class cl ON a.class_id = cl.id
            INNER JOIN Course c ON cl.Course_id = c.Course_id
            WHERE cl.Semester_id = ? AND a.reg_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ii", $semid, $regid);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendance = array();
    while ($row = $result->fetch_assoc()) {
        $percentage = ($row['TOT PRESENT'] / $row['TOT NO CLASS']) * 100;
        $row['PERSENTAGE'] = $percentage;
        $attendance[] = $row;
    }
 
    $stmt->close();
    return $attendance;
}

function marks($regid, $semid) {
    
    if ($this->conn === null) {
        echo "Database connection is not established.";
        return;
    }
    $query = "SELECT Marks.Exam_id AS courseid, Course.Course AS course, Marks.tot_mark AS `TOT MARKS`, Marks.mark AS `MARKS SCORED`
            FROM Marks
            JOIN Exam ON Marks.Exam_id = Exam.ID
            JOIN Course ON Exam.Course_id = Course.Course_id
            WHERE Exam.Semester_id = ? AND Marks.reg_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ii", $semid, $regid);
    $stmt->execute();
    $result = $stmt->get_result();

    $marks = array();
    while ($row = $result->fetch_assoc()) {
        $marks[] = $row;
    }

    $stmt->close();
    return $marks;
}

function seminfo() {
    
    if ($this->conn === null) {
        echo "Database connection is not established.";
        return;
    }
    $query = "SELECT * FROM Semester";
    $result =$this->conn->query($query);

    $seminfo = array();
    while ($row = $result->fetch_assoc()) {
        $seminfo[] = $row;
    }

    return $seminfo;
}

function timetable($semid) {
    
    if ($this->conn === null) {
        echo "Database connection is not established.";
        return;
    }
    $query = "SELECT Exam.Name AS Exam_Name, Course.Course AS Course_Name, Exam.date_of_exam AS Exam_Date
            FROM Exam
            JOIN Course ON Exam.Course_id = Course.Course_id
            WHERE Exam.Semester_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $semid);
    $stmt->execute();
    $result = $stmt->get_result();

    $timetable = array();
    while ($row = $result->fetch_assoc()) {
        $timetable[] = $row;
    }

    $stmt->close();
    return $timetable;
}

function insert_profile($reg_id, $address, $phone, $blood_group, $department, $cgpa, $dob) {
    // Ensure $conn is initialized and not null
    if ($this->conn === null) {
        echo "Database connection is not established.";
        return;
    }

    $query = "INSERT INTO Profile (reg_id, Address, Phone, Blood_Group, Department, CGPA, Dob)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("issssis", $reg_id, $address, $phone, $blood_group, $department, $cgpa, $dob);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return array("status" => "success");
    } else {
        return array("status" => "failed", "error" => $stmt->error);
    }

    $stmt->close();
}


function view_profile($regid) {
    
    if ($this->conn === null) {
        echo "Database connection is not established.";
        return;
    }
    $query = "SELECT * FROM Profile WHERE reg_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $regid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        return $user;
    } else {
        return array("error" => "User profile not found.");
    }

    $stmt->close();
}

function update_profile($reg_id, $address, $phone, $blood_group, $department, $cgpa, $dob) {
    if ($this->conn === null) {
        echo "Database connection is not established.";
        return;
    }
    $query = "UPDATE Profile SET Address = ?, Phone = ?, Blood_Group = ?, Department = ?, CGPA = ?, Dob = ?
            WHERE reg_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ssssssi", $address, $phone, $blood_group, $department, $cgpa, $dob, $reg_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return array("status" => "success");
    } else {
        return array("status" => "No records updated", "error" => $stmt->error);
    }

    $stmt->close();
}

// Close connection

}

?>
