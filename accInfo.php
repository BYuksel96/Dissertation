<?php

include('connection.php');

session_start();

if(isset($_SESSION["accType"])){ // Checking the accType session is set
    $acc_type = $_SESSION['accType']; // Storing session value in a variable
    $response = json_encode(array('type' => 'success', 'text' => $acc_type)); // Encoding the variable as a JSON object so it can be accessed on the frontend
    die($response); // Exiting the program and returning the value of the account type
}

?>