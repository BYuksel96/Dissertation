<?php
    /*
    * PHP fill used to:
    * 1. Change the state of a student ticket to FALSE to identify that help has finished
    * 2. Post helper feedback form data to the helper_feedback table
    */

    include('connection.php');
    session_start();

    if(isset($_POST['itemNum'])){

        $itemID = mysqli_real_escape_string($connection, $_POST['itemNum']); // Storing the posted value into a variable
        
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

    if(isset($_POST['categories'])){

        $category = mysqli_real_escape_string($connection, $_POST['categories']);
        $info = mysqli_real_escape_string($connection, $_POST['moreinfo']);
        $ticketID = mysqli_real_escape_string($connection, $_POST['ticketNumber']);

        $demName = $_SESSION["demonstrator"];
        // select query to acquire demonstrator id
        $sqlQueryID = mysqli_query($connection, "SELECT ID FROM users WHERE Username = '$demName'"); // finding student number associated with the ticket number
        $resultDemID = mysqli_fetch_assoc($sqlQueryID); // Acquiring the result of the query
        $demonID = $resultDemID["ID"];

        $changeState = mysqli_query($connection, "INSERT INTO helper_feedback(users_id, ticket_id, option_selected, comments) VALUES ('$demonID','$ticketID','$category','$info')");
        if(!$changeState){
            $output = "Error" . mysqli_error();
            $response = json_encode(array('type' => 'error', 'text' => $output));
            die($response);
        } else {
            $response = json_encode(array('type' => 'success', 'text' => 'All done.'));
            die($response);
        }
    }

?>