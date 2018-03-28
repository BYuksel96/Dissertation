<?php
    include('connection.php');
    session_start();

    $student = $_SESSION["studentNumber"];

    if(isset($_POST['itemQ'])){

        $itemID = $_POST['itemQ']; //sotring ticket number in here
        $sqlQuery = mysqli_query($connection, "SELECT StudentID FROM help_request WHERE TicketNo = '$itemID'"); //fidning student number associated with the ticket number
        $result = mysqli_fetch_assoc($sqlQuery); //fetching the result

        //sql query which will stop any user from deleting content - checking if students id, that is stored in the session var, matches the ticket number
        if($student == $result["StudentID"]) {

            $sqlQuery = "DELETE FROM help_request WHERE TicketNo = '$itemID'";
    
            if (mysqli_query($connection, $sqlQuery)){
                $response = json_encode(array('type' => 'success', 'text' => 'Item is deleted')); //message to send back to client side
                die($response);
            } else {
                $response = json_encode(array('type' => 'error', 'text' => 'Cannot delete the item')); //message to send back to client side
                die($response);
            }

        } else {
            $response = json_encode(array('type' => 'error', 'text' => 'Cannot do this action')); //message to send back to client side
            die($response);
        }

    }
    mysqli_close($connection);
?>