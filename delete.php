<?php
    /*
    * PHP file used to delete a help request ticket from the queue.
    * Works by using the stored student id session variable to find help request ticket in the help_request table.
    * A query is then used to delete it from in there.
    */

    include('connection.php');
    session_start();

    $student = $_SESSION["studentNumber"]; // Sotring session value in a var
    
    if (isset($_SESSION["editItem"])){
        $_SESSION["editItem"] = ""; // Reseting session value
    }

    if(isset($_POST['itemNum'])){

        $itemID = mysqli_real_escape_string($connection, $_POST['itemNum']); // storing ticket number in var
        $sqlQuery = mysqli_query($connection, "SELECT StudentID FROM help_request WHERE TicketNo = '$itemID'"); // fidning student number associated with the ticket number
        $result = mysqli_fetch_assoc($sqlQuery); // fetching the result

        // sql query which will stop any user from deleting content which doesn't belong to them - checking if the students id, that is stored in the session var, matches the ticket number
        if($student == $result["StudentID"]) {

            $sqlQuery = "DELETE FROM help_request WHERE TicketNo = '$itemID'"; // Query to delete ticket from the system/queue
    
            if (mysqli_query($connection, $sqlQuery)){
                $response = json_encode(array('type' => 'success', 'text' => 'Item is deleted'));
                die($response);
            } else {
                $response = json_encode(array('type' => 'error', 'text' => 'Cannot delete the item'));
                die($response);
            }

        } else {
            $response = json_encode(array('type' => 'error', 'text' => 'Cannot do this action'));
            die($response);
        }

    }
    mysqli_close($connection);
?>