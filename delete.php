<?php
    include('connection.php');
    session_start();

    if(isset($_POST['itemQ'])){
        
        $itemID = $_POST['itemQ'];

        $sqlQuery = "DELETE FROM help_request WHERE TicketNo = '$itemID'";

        if (mysqli_query($connection, $sqlQuery)){
            $response = json_encode(array('type' => 'success', 'text' => 'Item is deleted')); //message to send back to client side
            die($response);
        } else {
            $response = json_encode(array('type' => 'error', 'text' => 'Cannot delete the item')); //message to send back to client side
            die($response);
        }

    }
    mysqli_close($connection);
?>