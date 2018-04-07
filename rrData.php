<?php

    include('connection.php');

    session_start();

    if(isset($_POST['reset'])){
        $sql = mysqli_multi_query($connection,
            "DELETE FROM help_data;" .
            "ALTER TABLE `help_data` AUTO_INCREMENT = 1;");
        
        if($sql){
            $response = json_encode(array('type' => 'success', 'text' => 'Help Request Data Table has been reset!')); //message to send back to client side
            die($response);
        }else {
            $response = json_encode(array('type' => 'error', 'text' => 'Was not able to carry out your request... Please try again!')); //message to send back to client side
            die($response);
        }
    } else if(isset($_POST['id'])){
        $help_data_id = $_POST['id'];
        $result = "DELETE FROM help_data WHERE ID = '$help_data_id'";
        if(mysqli_query($connection,$result)){
            $response = json_encode(array('type' => 'success', 'text' => 'The item has now been removed.')); //message to send back to client side
            die($response);
        }else {
            $response = json_encode(array('type' => 'error', 'text' => 'Was not able to carry out your request... Please try again!')); //message to send back to client side
            die($response);
        }
    }

?>