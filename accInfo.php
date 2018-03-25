<?php

include('connection.php');

session_start();

if(isset($_SESSION["accType"])){
    $acc_type = $_SESSION['accType'];
    $response = json_encode(array('type' => 'success', 'text' => $acc_type));
    die($response);
}

?>