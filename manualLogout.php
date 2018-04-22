<?php
    // PHP file which, when activated, will manually logout a student from the system. (Student is chosen by the admin)

    include('connection.php');
    session_start();

    if (isset($_POST['id'])){
        $studentID = mysqli_real_escape_string($connection, $_POST['id']); // Storing the student ID (i.e. the students numbers)
        $result = "DELETE FROM students WHERE StudentID = '$studentID'"; // Removing student from the DB table 'students'
        if(mysqli_query($connection,$result)){
            $response = json_encode(array('type' => 'success', 'text' => 'Logged student out.')); //message to send back to client side
            die($response);
        }else {
            $response = json_encode(array('type' => 'error', 'text' => 'Was not able to log student out.')); //message to send back to client side
            die($response);
        }
        
    } else {
        $response = json_encode(array('type' => 'error', 'text' => 'Was not able to log student out.')); //message to send back to client side
        die($response);
    }

?>