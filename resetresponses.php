<?php
    /*
    * PHP file which, when called, will reset all the help feedback that was acquired (all is deleted from the helper_feedback table in the DB)
    */

    include('connection.php');
    session_start();

    if(isset($_SESSION["accType"])){ // Checking if the account type is set

        if($_SESSION["accType"] == "admin"){ // Checking if the person requesting this function is an admin
            
            $sql = mysqli_multi_query($connection,
                "DELETE FROM `helper_feedback`;" .
                "ALTER TABLE `helper_feedback` AUTO_INCREMENT = 1;");
            if($sql){ // If all queries were successfull then such a message will be sent back (to the js file) and displayed to the user
                $output = "Helper responses have been removed and reset.";
                $response = json_encode(array('type' => 'success', 'text' => $output));
                die($response);
            }else{
                $output = "Error" . mysqli_error();
                $response = json_encode(array('type' => 'error', 'text' => $output));
                die($response);
            }
        
        }
    
    }

?>