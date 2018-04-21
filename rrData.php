<?php
    // Reset or Remove Data.
    // This file is used to either completely reset all the help data which was provided by the systems admin.
    // Or specifically remove chosen items from the help data (DB table).
    include('connection.php');

    session_start();

    if(isset($_POST['reset'])){ // If reset button was clicked on account.php (in the 'Reset or Delete...' accordion card) then the everything will be deleted from the help_data DB table
        $sql = mysqli_multi_query($connection,
            "DELETE FROM help_data;" .
            "ALTER TABLE `help_data` AUTO_INCREMENT = 1;"); // Multi query used to both delete the data and reset the Auto Increment value to one for the ID's
        
        if($sql){
            $response = json_encode(array('type' => 'success', 'text' => 'Help Request Data Table has been reset!')); //message to send back to client side
            die($response);
        }else {
            $response = json_encode(array('type' => 'error', 'text' => 'Was not able to carry out your request... Please try again!')); //message to send back to client side
            die($response);
        }
    } else if(isset($_POST['id'])){ // If remove button is pressed then using the items ID only that specfic entry will be removed from the help_data DB table
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