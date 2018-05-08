<?php
    // This file is used to reset the whole system.
    // It clears the help_request, help_completed and helper_feedback tables.
    // All ID's start from 1 again.

    include('connection.php');
    session_start();

    if(isset($_SESSION["accType"])){ // Checking if the account type is set

        if($_SESSION["accType"] == "admin"){ // Checking if the person requesting this function is an admin
            
            // Below is a multi query. Used to carry out multiple sql queries.
            $sql = mysqli_multi_query($connection,
                "DELETE FROM `help_request`;" . 
                "ALTER TABLE `help_request` AUTO_INCREMENT = 1;" . 
                "DELETE FROM `help_completed`;" . 
                "ALTER TABLE `help_completed` AUTO_INCREMENT = 1;" .
                "DELETE FROM `helper_feedback`;" .
                "ALTER TABLE `helper_feedback` AUTO_INCREMENT = 1;");

            if($sql){ // If all queries were successfull then such a message will be sent back (to the js file) and displayed to the user
                $output = "System has been reset";
                $response = json_encode(array('type' => 'success', 'text' => $output));
                die($response);
            }else{
                $output = "Error" . mysqli_error();
                $response = json_encode(array('type' => 'error', 'text' => $output));
                die($response);
            }

        } else {
            $output = "Only Admins can carry out this action";
            $response = json_encode(array('type' => 'error', 'text' => $output));
            die($response);
        }

    } else {
        $output = "Only Admins can carry out this action";
        $response = json_encode(array('type' => 'error', 'text' => $output));
        die($response);
    }

    mysqli_close($connection);

?>