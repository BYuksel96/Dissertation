<?php

    include('connection.php');
    session_start();

    if(isset($_POST['itemNum'])){

        $itemID = $_POST['itemNum']; // Storing the posted value into a variable
        
        $changeState = mysqli_query($connection, "UPDATE help_request SET active_check = \"FALSE\", TimeHelpFinished = NOW() WHERE TicketNo = '$itemID'");
        if(!$changeState) {
            $output = "Error" . mysqli_error();
            $response = json_encode(array('type' => 'error', 'text' => $output));
            die($response);
        } else {
            $response = json_encode(array('type' => 'success', 'text' => 'Help Completed :)'));
            die($response);
        }

    }



?>