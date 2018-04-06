<?php
    include('connection.php');
    session_start();

    if(isset($_SESSION["accType"])){ // Checking if the account type is set

        if($_SESSION["accType"] == "admin"){ // Checking if the person requesting this function is an admin
            
            $sql = mysqli_multi_query($connection,
                "DELETE FROM `help_request`;" . 
                "ALTER TABLE `help_request` AUTO_INCREMENT = 1;" . 
                "DELETE FROM `help_completed`;" . 
                "ALTER TABLE `help_completed` AUTO_INCREMENT = 1;");

            // $sql = mysqli_query($connection, "DELETE FROM help_completed WHERE 0");
            if($sql){
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