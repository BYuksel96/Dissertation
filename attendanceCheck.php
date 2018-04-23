<?php

include('connection.php');
session_start();

if(isset($_SESSION["accType"])){ // Checking the accType session is set
    
    $studentID = "";
    if(isset($_SESSION["studentNumber"])){
        $studentID = $_SESSION["studentNumber"];
    } else {
        $response = json_encode(array('type' => 'error', 'text' => 'Not a student.')); // Encoding the variable as a JSON object so it can be accessed on the frontend
        die($response); // Exiting the program and returning the value of the account type
    }
     // Storing session value in a variable
    $ticketCheck = mysqli_query($connection, "SELECT * FROM help_request WHERE StudentID = '$studentID' AND active_check = 'ATTENDING'") or die (mysqli_error());

    if(mysqli_num_rows($ticketCheck) != 0){
        $updateTicket = mysqli_query($connection, "UPDATE help_request SET active_check = 'STUDENT NOTIFIED' WHERE StudentID = '$studentID' AND active_check = 'ATTENDING'") or die (mysqli_error());
        if(!$updateTicket){
            $response = json_encode(array('type' => 'error', 'text' => 'This help request has already been completed')); // Encoding the variable as a JSON object so it can be accessed on the frontend
            die($response); // Exiting the program and returning the value of the account type
        } else {
            $response = json_encode(array('type' => 'success', 'text' => 'A demonstrator will be with you now.')); // Encoding the variable as a JSON object so it can be accessed on the frontend
            die($response); // Exiting the program and returning the value of the account type
        }
    } else {
        $response = json_encode(array('type' => 'error', 'text' => 'This help request has already been completed')); // Encoding the variable as a JSON object so it can be accessed on the frontend
        die($response); // Exiting the program and returning the value of the account type
    }

} else {
    $response = json_encode(array('type' => 'error', 'text' => 'You have logged out. Please log back in.')); // Encoding the variable as a JSON object so it can be accessed on the frontend
    die($response); // Exiting the program and returning the value of the account type
}

?>