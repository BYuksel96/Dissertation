<?php

include('connection.php');
session_start();

$_SESSION["accType"] = "";
$_SESSION["studentNumber"] = "";
$_SESSION["studentName"] = "";

if (isset($_POST['name'])){
    $studentName = mysqli_real_escape_string($connection, $_POST['name']);
    $studentID = mysqli_real_escape_string($connection, $_POST['stuNum']);


    $accCheck = mysqli_query($connection, "SELECT * FROM students WHERE studentid = '$studentID'");
    if (mysqli_num_rows($accCheck) != 0){
        $response = json_encode(array('type' => 'error', 'text' => 'That student number is already in use...')); //message to send back to client side
        die($response);
    }
    else {
        $sql = mysqli_query($connection, "INSERT INTO students(studentid, studentname) VALUES ('$studentID','$studentName')");
        if(!$sql) {
            $output = "Error creating account. Error message: " . mysqli_error();
            $response = json_encode(array('type' => 'error', 'text' => $output));
            die($response);
        }
        else {
            $response = json_encode(array('type' => 'success', 'text' => 'Success: Account has been created!'));
            $_SESSION["accType"] = "student"; 
            $_SESSION["studentNumber"] = $studentID;
            $_SESSION["studentName"] = $studentName;
            die($response);
        }
    }
}
mysqli_close($connection);
?>