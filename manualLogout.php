<?php
    include('connection.php');
    session_start();

    if (isset($_POST['id'])){
        $studentID = $_POST['id'];
        $result = "DELETE FROM students WHERE StudentID = '$studentID'";
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