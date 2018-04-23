<?php

    include('connection.php');
    session_start();

    if(isset($_POST['itemNum'])) {
        $ticketID = $_POST['itemNum'];

        $sqlDelete = mysqli_query($connection, "DELETE FROM help_completed WHERE ticket_no = '$ticketID'") or die(mysqli_error());
        if(!$sqlDelete){
            $response = json_encode(array("type" => "error", "text" => "Error issuing request. Try Again."));
            die($response);
        }else {
            $changeState = mysqli_query($connection, "UPDATE help_request SET active_check = \"ASSISTANCE\" WHERE TicketNo = '$ticketID'");
            if(!$changeState){
                $response = json_encode(array("type" => "error", "text" => "Error issuing request. Try Again."));
                die($response);
            } else {
                $response = json_encode(array("type" => "success", "text" => "Your request has been made and other helpers will be notified."));
                die($response);
            }
        }

    }

?>